function renderHtmlImage(srcImage) {
    return `<div class="card col-md-3 mr-2">
    <img class="card-img-top image_detail_product" id = "output" src="${srcImage}" alt="">
    </div>`;
}
function renderHtmlImage1(srcImage) {
    return `<div class="card col-md-3 mr-2">
    <img class="card-img-top image_detail_product" src="${srcImage}" alt="">
    </div>`;
}
function loadPreviewMutipleImage() {
    let files = $(this).get(0).files;
    $("span.numFiles").text(files.length + " files");
    console.log(files);
    let fileLength = files.length;
    $(".image_detail_wrapper").html("");
    for (let i = 0; i < fileLength; i++) {
        let fileItem = files[i];
        const reader = new FileReader();
        reader.onload = function (element) {
            let data = renderHtmlImage1(element.target.result);
            $(".image_detail_wrapper").append(data);
        };

        reader.readAsDataURL(fileItem);
    }
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
var loadFile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
    console.log(URL.revokeObjectURL(output.src));
    output.onload = function () {
        let data = renderHtmlImage(event.target.files[0]);
        $(".image-detail").append(data);
    };
    URL.revokeObjectURL(output.src); // free memory
};

$(document).on("change", ".preview_image_detail", loadPreviewImage);
$(document).on("change", ".preview_image_multiple", loadPreviewMutipleImage);

$(document).ready(function () {
    $(".js-select-2").select2({
        theme: "classic",
    });
});
