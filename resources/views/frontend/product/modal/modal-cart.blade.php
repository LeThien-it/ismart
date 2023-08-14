<div class="modal fade" id="add-cart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog .modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $variant->product->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-3 px-sm-4">
                        <img class="img-modal" src="" alt="">
                    </div>
                    <div class="col-9 d-table">
                        <p class="modal-pro-name">Sản phẩm <b></b> được thêm vào giỏ hàng.</p>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <a href="{{ route('cart.show') }}" class="btn btn-primary">Xem giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
