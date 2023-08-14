<div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đánh giá và nhận xét sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">×</span> --}}
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('frontend.rating.add',request()->code) }}" method="POST" id="form-review">
                    @csrf
                    <div class="form-froup mb-3">
                        <input class="form-control" type="text" name="name" placeholder="Họ và tên">
                    </div>

                    <div class="form-froup mb-3">
                        <input class="form-control" type="text" name="phone" placeholder="Số điện thoại">
                    </div>

                    <div class="form-froup mb-3">
                        <input class="form-control" type="text" name="address" placeholder="Địa chỉ">
                    </div>
                    
                    <div class="form-froup mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email">
                    </div>
                    
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="content" id="" cols="30" rows="3"
                            placeholder="Mời bạn chia sẻ thêm một số cảm nhận về sản phẩm ..."></textarea>
                    </div>
                    <div class="form-vote mb-3">
                        <p>Bạn cảm thấy sản phẩm như thế nào?</p>
                        <div id="ratingId" class="custom-stars">
                            <ul>
                                <li>
                                    <i class="fas fa-star"></i>
                                    <span>Rất tệ</span>
                                </li>
                                <li>
                                    <i class="fas fa-star"></i>
                                    <span>Tệ</span>
                                </li>
                                <li>
                                    <i class="fas fa-star"></i>
                                    <span>Bình thường</span>
                                </li>
                                <li>
                                    <i class="fas fa-star"></i>
                                    <span>Tốt</span>
                                </li>
                                <li>
                                    <i class="fas fa-star"></i>
                                    <span>Tuyệt vời</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input class="btn btn-primary w-100 js-review" type="submit" value="Gửi đánh giá">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
