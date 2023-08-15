<style>
    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
    }
    .box-body:before{
        content: " ";
        display: table;
    }
    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table td {
        padding: .55rem;
         height: 30px;
        line-height: 30px;
        border-color: #f0f0f0;
    }
    .box-header {
        padding: 0.2rem;

    }
</style>

<div class="dashboard-title card">
    <div class="card-body">
        <div class="text-left ">
            <div class="box-header with-border">
                <h3 class="box-title">Environment</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <tbody>
                        <tr>
                            <td width="150px">URL</td>
                            <td><a target="_blank" href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a></td>
                        </tr>
                        <tr>
                            <td width="150px">PHP version</td>
                            <td>PHP/7.4.9</td>
                        </tr>
                        <tr>
                            <td width="150px">Laravel version</td>
                            <td>{{ \Illuminate\Foundation\Application::VERSION }}</td>
                        </tr>

                        <tr>
                            <td width="150px">Server</td>
                            <td>nginx/1.18.0</td>
                        </tr>
                        <tr>
                            <td width="150px">Cache driver</td>
                            <td>{{ config('cache.default') }}</td>
                        </tr>
                        <tr>
                            <td width="150px">Session driver</td>
                            <td>{{ config('session.driver') }}</td>
                        </tr>
                        <tr>
                            <td width="150px">Queue driver</td>
                            <td>{{ config('queue.default') }}</td>
                        </tr>
                        <tr>
                            <td width="150px">Timezone</td>
                            <td>{{ config('app.timezone') }}</td>
                        </tr>
                        <tr>
                            <td width="150px">Locale</td>
                            <td>{{ config('app.locale') }}</td>
                        </tr>
                        <tr>
                            <td width="150px">Env</td>
                            <td>{{ env('APP_ENV') }}</td>
                        </tr>

                        </tbody></table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>

