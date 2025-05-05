// Kiểm tra xem đã có thời gian đích trong localStorage chưa
let countdownDate = localStorage.getItem('countdownDate');
const now = new Date();
if (!countdownDate || new Date(parseInt(countdownDate)) < now) {
    // Nếu chưa có hoặc giá trị cũ đã hết hạn, thiết lập lại
    countdownDate = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000).getTime();
    localStorage.setItem('countdownDate', countdownDate);
} else {
    // Chuyển đổi từ string sang number nếu hợp lệ
    countdownDate = parseInt(countdownDate);
}

function updateCountdown() {
    const currentTime = new Date().getTime();
    const distance = countdownDate - currentTime;
    
    if (distance <= 0) {
        document.querySelector(".hot-deal-countdown").innerHTML = "<h3>Deal Ended!</h3>";
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").textContent = String(days).padStart(2, '0');
    document.getElementById("hours").textContent = String(hours).padStart(2, '0');
    document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
    document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
}

setInterval(updateCountdown, 1000);