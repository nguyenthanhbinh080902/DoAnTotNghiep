function toggleDropdown() {
    var dropdownContent = document.getElementById("dropdownContent");
    dropdownContent.classList.toggle("show");
}

// Đóng menu dropdown nếu click ra ngoài menu
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe sự kiện click trên các hàng có class "row-clickable"
    document.querySelectorAll('.row-clickable').forEach(function(row) {
        row.addEventListener('click', function() {
            // Lấy ID của dòng được nhấp vào từ thuộc tính data
            var id = this.getAttribute('data-id');
            // Chuyển hướng sang trang mới với ID được chọn
            window.location.href = '/xemCTPN/' + id;
        });
    });
});
  