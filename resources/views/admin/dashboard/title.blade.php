<style>
    .dashboard-title .links {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .dashboard-title .links > a {
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #fff;
    }
    .dashboard-title h1 {
        font-weight: 200;
        font-size: 2.5rem;
    }
    .dashboard-title .avatar {
        background: #fff;
        border: 2px solid #fff;
        width: 70px;
        height: 70px;
    }
</style>

<div class="dashboard-title card bg-primary">
    <div class="card-body">
        <div class="text-center ">
            <img class="avatar img-circle shadow mt-1" src="{{ admin_asset('@admin/images/logo.png') }}">

            <div class="text-center mb-1">
                <h1 class="mb-3 mt-2 text-white">ADMIN</h1>
                <div class="links">
                    <a href="javascript:;" data-href="{{ admin_url('product') }}" >產品列表</a>
                    <a href="javascript:;" data-href="{{ admin_url('order') }}">訂單列表</a>
                    <a href="javascript:;" data-href="{{ admin_url('article') }}" >文章列表</a>
                    <a href="javascript:;" data-href="{{ admin_url('article') }}" >留言信箱</a>
                    <a href="javascript:;" data-href="{{ admin_url('access-logs') }}">訪問記錄</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.links a').click(function(){
        location.href = $(this).attr('data-href');
    })

</script>
