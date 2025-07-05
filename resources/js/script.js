
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
});

// 商品削除確認モーダル
window.openDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'flex';
};

window.closeDeleteModal = function (productId) {
    document.getElementById(`deleteModal-${productId}`).style.display = 'none';
};

// 検索フォームのAjax送信処理
$(document).ready(function () {
    $('#search-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'GET',
            data: $(this).serialize(),
            dataType: 'html',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                $('#product-list').html(response);
            },
            error: function (xhr, status, error) {
                alert('検索に失敗しました。');
                console.error(error);
            }
        })
    })
})
