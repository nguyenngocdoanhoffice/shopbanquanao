@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="bg-white p-4 p-lg-5 rounded-4 shadow-sm">
                <h2 class="mb-3">Liên hệ</h2>
                <p class="text-muted mb-4">Bạn cần hỗ trợ đặt hàng hoặc tư vấn sản phẩm? Hãy liên hệ với chúng tôi.</p>
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-4" style="background: rgba(15, 23, 42, 0.04);">
                            <h6 class="mb-2">Thông tin cửa hàng</h6>
                            <p class="mb-1 text-muted">Hotline: 0900 123 456</p>
                            <p class="mb-1 text-muted">Email: nguyendoanh2110@gmail.com</p>
                            <p class="mb-0 text-muted">Địa chỉ: 136 Cầu Diễn , Minh Khai , Hà Nội</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <form class="bg-light p-3 rounded-4">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" placeholder="Nhập họ tên">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="you@email.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" rows="3" placeholder="Bạn cần hỗ trợ gì?"></textarea>
                            </div>
                            <button class="btn btn-brand" type="button">Gửi liên hệ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
