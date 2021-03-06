@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Izveštaji</h2>

            <div id="accordion" class="reports-accordion">
                <div class="card">
                    <div class="card-header p-1" id="headingCategories">
                        <h3 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                                Kategorije
                            </button>
                        </h3>
                    </div>
                    <div id="collapseCategories" class="collapse show" aria-labelledby="headingCategories" data-parent="#accordion">
                        <div class="card-body">
                            <form method="post" action="{{ route('reports.generate', [$board->address, 'categories']) }}">
                                @csrf
                                @php ($columns = $categories)
                                @include('admin.includes.report-form')
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-1" id="headingForums">
                        <h3 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseForums" aria-expanded="false" aria-controls="collapseForums">
                                Forumi
                            </button>
                        </h3>
                    </div>
                    <div id="collapseForums" class="collapse" aria-labelledby="headingForums" data-parent="#accordion">
                        <div class="card-body">
                            <form method="post" action="{{ route('reports.generate', [$board->address, 'forums']) }}">
                                @csrf
                                @php ($columns = $forums)
                                @include('admin.includes.report-form')
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-1" id="headingTopics">
                        <h3 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTopics" aria-expanded="false" aria-controls="collapseTopics">
                                Teme
                            </button>
                        </h3>
                    </div>
                    <div id="collapseTopics" class="collapse" aria-labelledby="headingTopics" data-parent="#accordion">
                        <div class="card-body">
                            <form method="post" action="{{ route('reports.generate', [$board->address, 'topics']) }}">
                                @csrf
                                @php ($columns = $topics)
                                @include('admin.includes.report-form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('input[type=checkbox]').change(function() {
                const select = $(this).parents('tr').find('select');
                if (this.checked) {
                    select.removeAttr('disabled');
                } else {
                    select.attr('disabled', '');
                }
            });
        });
    </script>
@stop
