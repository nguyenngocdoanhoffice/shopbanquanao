@php
    $profitValue = $profit ?? 0;
@endphp

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="mb-2">Lãi / Lỗ</h5>
            <p class="text-muted mb-3">Dựa trên đơn hàng đã hoàn thành.</p>
            <div class="fs-3 fw-semibold">
                {{ number_format($profitValue, 0) }} VND
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="mb-3">Sản phẩm bán chạy</h5>
            <ul class="list-group list-group-flush">
                @forelse ($topSelling as $row)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $row->product?->name ?? 'N/A' }}</span>
                        <span class="fw-semibold">{{ $row->sold_qty }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Chưa có dữ liệu.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="admin-card p-4 h-100">
            <h5 class="mb-3">Sản phẩm bán ít</h5>
            <ul class="list-group list-group-flush">
                @forelse ($lowSelling as $row)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $row->name ?? 'N/A' }}</span>
                        <span class="fw-semibold">{{ $row->sold_qty }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Chưa có dữ liệu.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
