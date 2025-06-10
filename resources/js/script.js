
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('img_path');
    const fileNameLabel = document.getElementById('file_name');

    if (fileInput && fileNameLabel) {
        fileInput.addEventListener('change', function () {
            const fileName = this.files[0]?.name || '選択されていません';
            fileNameLabel.textContent = fileName;
        });
    }

    // 商品登録・更新・削除成功時のモーダル
    const modal = document.getElementById('successModal');
    const closeBtn = document.getElementById('closeModal');

    if (modal && closeBtn) {
        closeBtn.addEventListener('click', function () {
            modal.classList.remove('is-visible');
        });
    }

    // 商品登録・更新・削除失敗時のモーダル
    const errorModalRegister = document.getElementById('errorModal');
    const closeErrorRegister = document.getElementById('closeErrorModal');
    if (errorModalRegister && closeErrorRegister) {
        closeErrorRegister.addEventListener('click', () => {
            errorModalRegister.classList.remove('is-visible');
        });
    }

    // // 商品削除時のモーダル
    // const successModal = document.getElementById('successModal');
    // const closeSuccess = document.getElementById('closeSuccessModal');

    // if (successModal && closeSuccess) {
    //     closeSuccess.addEventListener('click', () => {
    //         successModal.classList.remove('is-visible');
    //     });
    // }

    // // 商品削除失敗時のモーダル
    // const errorModalDelete = document.getElementById('errorModalDelete');
    // const closeErrorDelete = document.getElementById('closeErrorModalDelete');
    // if (errorModalDelete && closeErrorDelete) {
    //     closeErrorDelete.addEventListener('click', () => {
    //         errorModalDelete.classList.remove('is-visible');
    //     });
    // }
});

// 商品削除時のモーダル
window.openDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'flex';
};

window.closeDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'none';
};
