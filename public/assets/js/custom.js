document.addEventListener("DOMContentLoaded", function () {
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
    messageElement.textContent =
      "Chúc bạn có một buổi chiều làm việc hiệu quả!";
    imgElement.src = "/assets/images/icon/sunsets.png"; // Thay thế bằng URL ảnh buổi chiều
  } else {
    titleElement.textContent = "Chào buổi tối!";
    messageElement.textContent = "Chúc bạn một buổi tối thư giãn và an lành!";
    imgElement.src = "/assets/images/icon/half-moon.png"; // Thay thế bằng URL ảnh buổi tối
  }
});

const loading = document.getElementById("loading");

// Add loading spinner for all <a> and <form>
document.addEventListener("click", function (event) {
  const target = event.target;

  // Handle links (<a>)
  if (
    target.tagName === "A" &&
    target.getAttribute("href") !== "#" &&
    target.getAttribute("target") !== "_blank"
  ) {
    loading.style.display = "flex";
  }

  // Handle forms (<form>)
  if (target.tagName === "FORM" || target.closest("form")) {
    loading.style.display = "flex";
  }
});

// Ensure loading spinner shows during page navigation
window.onbeforeunload = function () {
  loading.style.display = "flex";
};

(function ($) {
  "use strice";

  // Hiển thị đếm thông báo
  function fetchCount(){
    $.ajax({
      url: '/count-notify',
      type: 'GET',
      success: function (response) {
        $('#notify-count').text(`${response.count} thông báo mới`);
      },
    })
  }

  fetchCount();

})(jQuery);




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

// (function ($) {
//   "use strict";

//   if ($(".select2-manager").length) {
//     $(".select2-manager").select2({
//       placeholder: "Chọn một mục...",
//       allowClear: true,
//       ajax: {
//         url: "/search-user-manager", // Đường dẫn API
//         type: "GET",
//         dataType: "json",
//         delay: 250, // Trì hoãn trước khi gửi request (ms)
//         data: function (params) {
//           return {
//             search: params.term, // Tham số tìm kiếm từ input
//             // page: params.page || 1, // Phân trang (nếu API hỗ trợ)
//           };
//         },
//         processResults: function (data) {
//           // Chuyển đổi dữ liệu API thành định dạng Select2
//           return {
//             results: data.items.map((item) => ({
//               id: item.id, // Giá trị của item
//               text: item.text, // Text hiển thị
//             })),
//           };
//         },
//         cache: true, // Bật cache cho request
//       },
//     });
//   }
// })(jQuery);

// (function ($) {
//   "use strict";

//   if ($(".select2-manager").length) {
//     // Bước 1: Lấy giá trị mặc định đã được chọn
//     var defaultManagerId = $('#manager').val(); // Giá trị từ option mặc định trong HTML
//     var defaultManagerText = $('#manager option:selected').text(); // Text hiển thị của giá trị mặc định

//     // Bước 2: Gọi API để lấy dữ liệu
//     $.ajax({
//       url: '/search-user-manager', // Đường dẫn API
//       type: 'GET',
//       dataType: 'json',
//       success: function (data) {
//         if (!data || !Array.isArray(data)) {
//           console.error("Dữ liệu API không hợp lệ.");
//           return;
//         }

//         var options = '';

//         // Bước 3: Thêm giá trị mặc định nếu chưa có trong dữ liệu API
//         if (defaultManagerId && defaultManagerText) {
//           options += `
//             <option value="${defaultManagerId}" selected>
//               ${defaultManagerText}
//             </option>`;
//         }

//         // Bước 4: Thêm các option từ API
//         $.each(data, function (key, user) {
//           if (user.id != defaultManagerId) { // Tránh thêm lại giá trị mặc định
//             options += `
//               <option value="${user.id}">
//                 ${user.text}
//               </option>`;
//           }
//         });

//         // Bước 5: Gắn các option mới vào select
//         $(".select2-manager").html(options);

//         // Bước 6: Khởi tạo hoặc làm mới Select2
//         $(".select2-manager").select2({
//           placeholder: "Chọn Trưởng Phòng",
//           dropdownParent: $(".mb-3.form-group"),
//         });
//       },
//       error: function () {
//         console.error("Lỗi khi tải dữ liệu từ API.");
//       }
//     });
//   }
// })(jQuery);

// (function ($) {
//   "use strict";

//   $("#manager").selectize({
//     plugins: ["restore_on_backspace", "clear_button"],
//     delimiter: " - ",
//     persist: false,
//     maxItems: null,
//     valueField: "email",
//     labelField: "name",
//     searchField: ["name", "email"],
//     options: [
//       { email: "selectize@risadams.com", name: "Ris Adams" },
//       { email: "someone@gmail.com", name: "Someone" },
//       { email: "someone-else@yahoo.com", name: "Someone Else" },
//     ],
//   });
// })(jQuery);
