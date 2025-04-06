function selectPackage(level) {

    document.querySelectorAll('.vip-card').forEach(card => {
        card.classList.remove('package-selected');
    });
    
    document.getElementById('package-' + level).classList.add('package-selected');
    document.getElementById('selected_vip').value = level;
    document.getElementById('btn-continue').disabled = false;
}
function validateUsernameForm() {
    const username = document.getElementById('username').value.trim();
    if (username === '') {
        alert('Silakan masukkan nama karakter Anda!');
        return false;
    }
    return true;
}