
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
    const errorModal = document.getElementById('errorModal');
    const closeErrorModal = document.getElementById('closeErrorModal');
    if (errorModal && closeErrorModal) {
        closeErrorModal.addEventListener('click', () => {
            errorModal.classList.remove('is-visible');
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

// ページネーションのAjax送信処理
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function (response) {
            $('#product-list').html(response);
        },
        error: function (xhr, status, error) {
            alert('ページ切り替えに失敗しました。');
        }
    })
})

// Ajaxでの削除処理
$(document).on('click', '.confirm-delete-button', function () {
    const productId = $(this).data('id');
    const modalId = `#deleteModal-${productId}`;

    $.ajax({
        url: `/products/${productId}`,
        type: 'POST',
        data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // 行を削除
                $(`#product-row-${productId}`).remove();
                // モーダルを閉じる
                $(modalId).hide();
                // 成功モーダル表示
                showSuccessModal('商品を削除しました。');
            } else {
                showErrorModal('削除に失敗しました。');
            }
        },
        error: function () {
            showErrorModal('通信エラーが発生しました。');
        }
    });
});

// 成功モーダル表示用関数
function showSuccessModal(message) {
    const successModal = document.getElementById('successModal');
    const messageElem = successModal.querySelector('.modal-content-message');

    if (messageElem) {
        messageElem.textContent = message;
    }

    successModal.classList.add('is-visible');
}

// エラーモーダル表示用関数
function showErrorModal(message) {
    const errorModal = document.getElementById('errorModal');
    const messageElem = errorModal.querySelector('.modal-content-message');

    if (messageElem) {
        messageElem.textContent = message;
    }

    errorModal.classList.add('is-visible');
}

