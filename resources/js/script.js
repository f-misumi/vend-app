
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('img_path');
    const fileNameLabel = document.getElementById('file_name');

    if (fileInput && fileNameLabel) {
        fileInput.addEventListener('change', function () {
            const fileName = this.files[0]?.name || '選択されていません';
            fileNameLabel.textContent = fileName;
        });
    }

    // 商品登録・更新時のモーダル表示
    const modal = document.getElementById('successModal');
    const closeBtn = document.getElementById('closeModal');

    if (modal && closeBtn) {
        closeBtn.addEventListener('click', function () {
            modal.classList.remove('is-visible');
        });
    }
});

// 商品削除時のモーダル表示
window.openDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'flex';
};

window.closeDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'none';
};
