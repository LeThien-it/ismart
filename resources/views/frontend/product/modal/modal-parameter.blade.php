<div class="modal fade" id="parameter-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thông số kỹ thuật</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">×</span> --}}
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="parameter-table">
                    {!! $product->parameter_detail !!}
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
