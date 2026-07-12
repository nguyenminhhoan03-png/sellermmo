@php use App\Helpers\Helper; @endphp
@include('layouts.header')
@include('layouts.nav') 
@yield('content')
@include('layouts.footer')
@if ($errors->any())
<script>
        showMessage('{{ $errors->first() }}','error')
    </script>
@endif                            
@if (session('success'))
    <script>
        $swal('success','{{ session('success') }}')
    </script>
@elseif (session('error'))
    <script>
         showMessage('{{ session('error') }}','error')
    </script>
@endif

<style>
.global-sales-toast {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #1e1e2d;
    color: #fff;
    padding: 12px 18px;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    max-width: 350px;
    font-size: 0.85rem;
    border: 1px solid rgba(255,255,255,0.1);
}
.global-sales-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.global-sales-toast-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fcd000, #ff9a00);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e1e2d;
    font-size: 1.2rem;
    flex-shrink: 0;
}
</style>
<div class="global-sales-toast" id="globalSalesToast">
    <div class="global-sales-toast-icon">
        <i class="bi bi-cart-check-fill"></i>
    </div>
    <div class="global-sales-toast-content" id="globalSalesToastContent">
        <!-- Content injected via JS -->
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let salesQueue = [];
    let isShowingSale = false;
    let shownSales = JSON.parse(sessionStorage.getItem('shownSales') || '[]');

    function fetchRecentSales() {
        fetch('/api/recent-sales')
            .then(res => res.json())
            .then(data => {
                if(data && data.length > 0) {
                    const newSales = data.filter(s => !shownSales.includes(s.id));
                    if (newSales.length > 0) {
                        salesQueue = salesQueue.concat(newSales);
                        if (!isShowingSale) {
                            setTimeout(showNextSale, Math.random() * 5000 + 3000);
                        }
                    }
                }
            })
            .catch(err => console.error(err));
    }

    function showNextSale() {
        if(salesQueue.length === 0) {
            isShowingSale = false;
            return;
        }
        
        isShowingSale = true;
        const sale = salesQueue.shift();
        
        shownSales.push(sale.id);
        if (shownSales.length > 50) shownSales.shift(); 
        sessionStorage.setItem('shownSales', JSON.stringify(shownSales));

        const toast = document.getElementById('globalSalesToast');
        const content = document.getElementById('globalSalesToastContent');
        
        content.innerHTML = `<div><b style="color:#fcd000;">${sale.username}</b> vừa mua</div><div style="font-weight:600;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${sale.content}</div><div style="font-size:0.75rem; color:#a1a5b7; margin-top:3px;"><i class="bi bi-clock me-1"></i>${sale.time} <i class="bi bi-check-all text-success ms-1"></i> thành công</div>`;
        
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                isShowingSale = false;
                showNextSale();
            }, Math.random() * 15000 + 15000); // Đợi 15-30s mới hiện cái tiếp theo
        }, 5000); // Hiện trong 5s
    }

    setTimeout(fetchRecentSales, 3000);
    setInterval(fetchRecentSales, 180000);
});
</script>

@yield('scripts')