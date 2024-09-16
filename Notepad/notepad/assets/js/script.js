document.addEventListener('DOMContentLoaded', function() {
    const alertBox = document.querySelector('.alert');

    // 2 saniye bekle, sonra fade-out class'ını ekle
    setTimeout(() => {
        alertBox.classList.add('fade-out');
    }, 1500);

    // Fade out animasyonu bittikten sonra alert'i tamamen kaldır
    alertBox.addEventListener('animationend', function(event) {
        if (event.animationName === 'fadeOut') {
            alertBox.remove();
        }
    });
});
//-------------------------------------------------------------------------------------------------------------------
