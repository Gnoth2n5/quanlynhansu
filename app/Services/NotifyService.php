<?php

namespace App\Services;

use Predis\Client;
use App\Models\Notifications;
use Carbon\Carbon;

class NotifyService extends Service
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new Client();
    }

    public function isRead($userId, $notificationId)
    {
        $key = "notifications:{$userId}:read";

        // Nếu trạng thái đã tồn tại, không cần thêm lại
        if (!$this->redis->hexists($key, $notificationId)) {
            $this->redis->hset($key, $notificationId, true);
        }

        // Chỉ đặt TTL nếu key chưa có hoặc vừa được cập nhật
        if (!$this->redis->ttl($key) || $this->redis->ttl($key) < 0) {
            $this->redis->expire($key, 60 * 60 * 24 * 15); // 15 ngày
        }

        return true;
    }

    /**
     * Lấy tất cả thông báo (cá nhân và theo phòng ban) kèm trạng thái isRead.
     */
    public function getUserNotifications($userId, $perPage, $page)
    {
        // Redis key
        $redisKey = "notifications:{$userId}:read";

        // Lấy thông báo trong 15 ngày gần nhất
        $startDate = Carbon::now()->subDays(15)->toDateTimeString();

        // Lấy thông báo cá nhân
        $personalNotifications = Notifications::select(
            'notifications.id',
            'notifications.title',
            'notifications.message as content',
            'notifications.created_at'
        )
            ->join('notify_user', 'notifications.id', '=', 'notify_user.notify_id')
            ->where('notify_user.user_id', $userId)
            ->where('notifications.created_at', '>=', $startDate)
            ->orderBy('notifications.created_at', 'desc')
            ->get()
            ->map(function ($notification) use ($redisKey) {
                $isRead = $this->redis->hExists($redisKey, $notification->id);
                return array_merge($notification->toArray(), [
                    'isRead' => $isRead,
                    'type' => 'personal',
                ]);
            })
            ->toArray();


        // Lấy thông báo phòng ban
        $officeNotifications = Notifications::select('notifications.id', 'notifications.title', 'notifications.message as content', 'notifications.created_at', 'offices.name as office_name')
            ->join('notify_office', 'notifications.id', '=', 'notify_office.notify_id')
            ->join('offices', 'notify_office.office_id', '=', 'offices.id')
            ->join('office_users', 'offices.id', '=', 'office_users.office_id')
            ->where('office_users.user_id', $userId)
            ->where('notifications.created_at', '>=', $startDate)
            ->orderBy('notifications.created_at', 'desc')
            ->get()
            ->map(function ($notification) use ($redisKey) {
                // Kiểm tra trong Redis
                $isRead = $this->redis->hExists($redisKey, $notification->id);
                return array_merge($notification->toArray(), [
                    'isRead' => $isRead,
                    'type' => 'office',
                ]);
            })
            ->toArray();

        // Merge và sắp xếp thông báo
        $mergedData = array_merge($personalNotifications, $officeNotifications);
        usort($mergedData, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Phân trang thủ công
        $offset = ($page - 1) * $perPage;
        $paginatedData = array_slice($mergedData, $offset, $perPage);

        return [
            'data' => $paginatedData,
            'totalPages' => ceil(count($mergedData) / $perPage),
            'currentPage' => $page,
            'totalRecords' => count($mergedData),
        ];
    }

    public function countUnreadNotifications($userId)
    {
        // Redis key lưu trữ thông báo đã đọc
        $redisKey = "notifications:{$userId}:read";

        // Lấy tổng số thông báo cá nhân và thông báo theo phòng ban
        $personalNotificationsCount = Notifications::join('notify_user', 'notifications.id', '=', 'notify_user.notify_id')
            ->where('notify_user.user_id', $userId)
            ->count();

        $officeNotificationsCount = Notifications::join('notify_office', 'notifications.id', '=', 'notify_office.notify_id')
            ->join('office_users', 'notify_office.office_id', '=', 'office_users.office_id')
            ->where('office_users.user_id', $userId)
            ->count();

        // Tổng số thông báo
        $totalNotifications = $personalNotificationsCount + $officeNotificationsCount;

        // Lấy danh sách tất cả thông báo đã đọc từ Redis
        $readNotifications = $this->redis->hGetAll($redisKey); // Trả về tất cả các field và value (thông báo đã đọc)

        // Số thông báo đã đọc là số lượng các keys trong hash
        $readNotificationsCount = count($readNotifications);

        // Số thông báo chưa đọc
        $unreadNotificationsCount = $totalNotifications - $readNotificationsCount;

        return $unreadNotificationsCount;
    }
}
