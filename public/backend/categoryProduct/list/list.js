function actionDelete(event) {
    event.preventDefault(); //mục đích là để nó k reload lại trang vì do khi click vào thẻ a nó sẽ dẫn tới 1 url nên cần preventDefault() để cắt liên kết sang url
    let urlRequest = $(this).attr("href"); //$(this) chính là button mà mình đang bấm vào
    // alert(urlRequest);
    let that = $(this); //$(this) là button khi trỏ vào
    let name = $(this).data("name");
    Swal.fire({
        title: "Bạn có chắc muốn xóa danh mục " + name + " không?",
        text: "Khi xóa mục này các mục con (nếu có) sẽ bị xóa theo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "hủy",
        cancelButtonColor: "#d33",
        confirmButtonText: "Tôi đồng ý",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function (data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        Swal.fire({
                            title:
                                data.module + " " + data.name + " đã được xóa",
                            showConfirmButton: true,
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function () {},
            });
        }
    });
}

$(function () {
    $(document).on("click", ".action_delete", actionDelete);
});

$(document).ready(function () {
    $(".js-select-2").select2({
        theme: "classic",
    });
});
