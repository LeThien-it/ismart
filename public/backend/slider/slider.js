function renderHtmlImage(srcImage) {
    return `<div class="card col-md-12 mr-2 mt-3">
    <img class="card-img-top image_detail_product" src="${srcImage}" alt="">
    </div>`;
}

function loadPreviewImage() {
    let file = $(this).get(0).files[[0]];
    console.log(file);
    $(".image-detail").html("");
    const reader = new FileReader();
    reader.onload = function (element) {
        let data = renderHtmlImage(element.target.result);
        $(".image-detail").append(data);
    };
    reader.readAsDataURL(file);
}

$(document).on("change", ".preview_image_detail", loadPreviewImage);



