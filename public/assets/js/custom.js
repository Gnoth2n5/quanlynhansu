document.addEventListener('DOMContentLoaded', function() {
  const currentHour = new Date().getHours();
const titleElement = document.getElementById("greeting-title");
const messageElement = document.getElementById("greeting-message");
const imgElement = document.getElementById("greeting-img");

// Chia theo các mốc thời gian: Sáng, Trưa, Chiều, Tối
if (currentHour < 12) {
  titleElement.textContent = "Chào buổi sáng!";
  messageElement.textContent = "Chúc bạn một ngày mới tràn đầy năng lượng!";
  imgElement.src = "/assets/images/icon/morning.png"; // Thay thế bằng URL ảnh buổi sáng
} else if (currentHour < 14) {
  titleElement.textContent = "Chào buổi trưa!";
  messageElement.textContent = "Chúc bạn một bữa trưa ngon miệng!";
  imgElement.src = "/assets/images/icon/lunch-time.png"; // Thay thế bằng URL ảnh buổi trưa
} else if (currentHour < 18) {
  titleElement.textContent = "Chào buổi chiều!";
  messageElement.textContent = "Chúc bạn có một buổi chiều làm việc hiệu quả!";
  imgElement.src = "/assets/images/icon/sunsets.png"; // Thay thế bằng URL ảnh buổi chiều
} else {
  titleElement.textContent = "Chào buổi tối!";
  messageElement.textContent = "Chúc bạn một buổi tối thư giãn và an lành!";
  imgElement.src = "/assets/images/icon/half-moon.png"; // Thay thế bằng URL ảnh buổi tối
}
});

// // Hàm cập nhật đồng hồ thời gian thực
// function updateClock() {
//     const clockElement = document.getElementById('time-badge');
//     const currentTime = new Date();
//     const hours = String(currentTime.getHours()).padStart(2, '0');
//     const minutes = String(currentTime.getMinutes()).padStart(2, '0');
//     const seconds = String(currentTime.getSeconds()).padStart(2, '0');
//     clockElement.textContent = `${hours}:${minutes}:${seconds}`;
// }

// // Cập nhật đồng hồ mỗi giây
// setInterval(updateClock, 1000);

// // Gọi hàm cập nhật đồng hồ ngay khi trang được tải
// updateClock();
