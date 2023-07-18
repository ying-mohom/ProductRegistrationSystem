
@if(isset($items) && $items->count() == 0 && $items->currentPage() > 1)
@php
// Get the current URL
$currentUrl = url()->current();

// Get the URL parameters as an associative array
$queryParams = request()->query();

// Set the previous page value
$previousPage = $queryParams['page'];

// Check if the previous page value exceeds the total number of available pages
$maxPage = $items->lastPage();
if ($previousPage > $maxPage) {
$previousPage = $maxPage;
}

// Set the updated page value in the query parameters
$queryParams['page'] = $previousPage;

// Generate the previous page URL with the updated query parameters
$previousPageUrl = $currentUrl . '?' . http_build_query($queryParams);

// Redirect to the previous page URL
header('Location: ' . $previousPageUrl);
exit;
@endphp
@endif

@extends('layouts.app')
@section('title')
    Item List
@endsection

<style>
    .page-item.active .page-link {
        background-color: #276678 !important;
        color: white;
    }

    .tableFixHead {
        overflow-y: auto;
        max-height: 350px;
        overflow-x: hidden;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        background-color: #ffffff;
        z-index: 1;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-10">
  
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-circle-check text-success"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-circle-check text-success"></i>
                        {{ session('message') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-exclamation text-danger"></i>
                        {{ session('error') }}
                    </div>
                @endif
                <div class="d-flex justify-content-end">

                    <div class="me-3">
                        <form action="{{ route('items.search') }}" method="GET" class="d-flex w-100">
                            <input type="hidden" name="search" value="pdf">
                            <input type="text" name="itemId" id="pdfItemId" hidden>
                            <input type="text" name="itemCode" id="pdfItemCode" hidden>
                            <input type="text" name="itemName" id="pdfItemName" hidden>
                            <input type="text" name="category" id="pdfCategory" hidden>
                            {{-- <input type="text" name="page" value="{{ $items->currentPage() }}" id="pdfPage" hidden> --}}
                            <button type="submit" class="btn btn-light shadow" style="color:#037171;"><b><i
                                        class="fa-solid fa-file-arrow-down mr-2"></i>
                                    {{ trans('language.pdf download') }}</b></button>
                        </form>
                    </div>

                    <div class="">
                        <form action="{{ route('items.search') }}" method="GET" class="d-flex w-100">
                            <input type="hidden" name="search" value="excel">
                            <input type="text" name="itemId" id="excelItemId" hidden>
                            <input type="text" name="itemCode" id="excelItemCode" hidden>
                            <input type="text" name="itemName" id="excelItemName" hidden>
                            <input type="text" name="category" id="excelCategory" hidden>
                            {{-- <input type="text" name="page" value="{{ $items->currentPage() }}" id="excelPage" hidden> --}}

                            <button type="submit" class="btn btn-light shadow" style="color:#037171;"><b><i
                                        class="fa-solid fa-file-excel"></i>
                                    {{ trans('language.excel download') }}</b></button>
                        </form>
                    </div>
                </div> <br>


                <form action="{{ route('items.search') }}"  method="GET" id="search-form">
                    <div class="row">
                        <input type="hidden" name="search" value="search">
                        {{-- <input type="text" name="page" value="{{ $items->currentPage() }}" hidden> --}}
                        <div class="col-2">
                            <label for="" class="ms-3">{{ trans('language.enter item id') }}</label><br>
                            <input type="text" class="form-control" name="itemId" id="itemId" value="" maxlength="10">
                        </div>
                        <div class="col-2">
                            <label for="" class="ms-3">{{ trans('language.enter item code') }}</label><br>
                            <input type="text" class="form-control" name="itemCode" id="itemCode" placeholder=""
                                value="" autocomplete="off"  maxlength="50">
                        </div>
                        <div class="col-3">
                            <label for="" class="ms-3">{{ trans('language.enter item name') }}</label><br>
                            <input type="text" class="form-control" id="itemName" name="itemName" placeholder=""
                                value="" autocomplete="off"  maxlength="100">
                        </div>
                        <div class="col-3">
                            <label for="" class="ms-3">{{ trans('language.choose category') }}</label><br>
                            <select class="form-select" aria-label="Default select example" name="category"
                                id="category">
                                <option value="">&nbsp;Choose &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-2">

                            <button type="submit" class="btn text-light w-100 mt-4" id="searchButton"
                                style="background-color:#1e82a4;"><i class="fas fa-search"></i>
                                {{ trans('language.search') }}...</button>
                        </div>
                    </div>



                </form><br>
                @if (count($items) == 0)
                    <h4 class="text-center">{{ trans('language.there is no item') }}</h4>
                @else
                    <table class="table text-center shadow-lg p-3 mb-5 bg-white rounded table-striped">
                        <div class="row">
                            <div class="col d-flex justify-content-start">
                                <h5 style="color:#037171;">{{ trans('language.item list') }}</h5>
                            </div>
                            <div class="col d-flex flex-row-reverse me-2">
                                <h6 class="" style="color:#037171;">{{ trans('language.total rows') }}:
                                    {{ $rowCount }}</h6>
                            </div>
                        </div>
                        <thead>
                            <tr style="" class="">
                                <th class="p-3">{{ trans('language.no') }}</th>
                                <th class="p-3">{{ trans('language.item id') }}</th>
                                <th class="p-3">{{ trans('language.item code') }}</th>
                                <th class="p-3">{{ trans('language.item name') }}</th>
                                <th class="p-3">{{ trans('language.category') }}</th>
                                <th class="p-3">{{ trans('language.safety stock') }}</th>
                                <th class="p-3">{{ trans('language.active inactive') }}</th>
                                <th class="p-3" colspan="3">{{ trans('language.action') }}</th>

                            </tr>
                        </thead>


                        <tbody>
                         
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->item_id }}</td>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->safety_stock }}</td>

                                    @if ($item->deleted_at == null)
                                        <td>
                                            <button class="btn text-light active-button"
                                                id="activeButton{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#inactiveModal"
                                                style="background-color: #1e82a4; width:100px;"
                                                value="{{ $item->id }}">Active</button>
                                        </td>
                                        <td><a href="{{ route('item.edit', $item->id) }}" title="Edit"><i
                                                    class="fa-regular fa-pen-to-square mt-2"
                                                    style="color:#037171;"></i></a>
                                        </td>
                                        <td><a href="{{ route('item.detail', $item->id) }}" title="Detail"><i
                                                    class="fa-regular fa-rectangle-list mt-2"
                                                    style="color:#037171;"></i></a>
                                        </td>

                                        <td>

                                            <button title="Delete" class="custom-button force-delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                id="delete{{ $item->id }}" value="{{ $item->id }}"><i
                                                    class="fa-solid fa-trash-can mt-2" style="color:#ff0000;"></i>
                                            </button>

                                        </td>
                                       
                                    @else
                                        <td><button class="btn text-light inactive-button"
                                                style="background-color:#999999; width:100px;"
                                                id="inactiveButton{{ $item->id }}"data-bs-toggle="modal"
                                                data-bs-target="#activeModal"
                                                value="{{ $item->id }}">Inactive</button>
                                        </td>
                                        <td> <a href="{{ route('item.edit', ['id' => $item->id]) }}"
                                                title="Unable to Edit" class="pe-none"><i
                                                    class="fa-regular fa-pen-to-square mt-2 "
                                                    style="color:#999999;"></i></a>
                                        </td>
                                        <td><a href="{{ route('item.detail', $item->id) }}" title="Detail"><i
                                                    class="fa-regular fa-rectangle-list mt-2"
                                                    style="color:#037171;"></i></a></td>
                                        </td>
                                        <td>

                                            <button type="submit" title="Unable to Delete" class="custom-button"
                                                disabled>
                                                <i class="fa-solid fa-trash-can mt-2"
                                                    style="color: #999999; pointer-events: none;"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @endif
                <div class="pagination-container">
                    {{ $items->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Box for Active Button -->
    <div id="inactiveModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content w-75" style="height: 140px; background-color:#FFFFFF;">
                <div class="row mt-4">
                    <b class="text-center" style="font-size: 18px;">Are you sure want to inactive ? </b>
                </div>
                <div class="row mt-3 mb-1 d-flex justify-content-between">
                    <button class="btn btn-success ms-5" id="changeInactive" value=""
                        style="width:90px;">Inactive</button>
                    <button class="btn btn-danger me-5" data-bs-dismiss="modal" style="width:90px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Box for Inactive Button -->
    <div id="activeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content w-75" style="height: 140px;background-color: #FFFFFF;">
                <div class="row mt-4">
                    <b class="text-center " style="font-size: 18px;">Are you sure want to active ? </b>
                </div>
                <div class="row mt-3 mb-1 d-flex justify-content-between">
                    <button class="btn btn-success ms-5" id="changeActive" value=""
                        style="width:90px;">Active</button>

                    <button class="btn btn-danger me-5" data-bs-dismiss="modal" style="width:90px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Box for Delete -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <input type="text" id = "itemCount" value="{{ $itemCount }}" hidden>
        <div class="modal-dialog">
            <div class="modal-content w-75" style="height: 140px;background-color: #FFFFFF;">
                <div class="row mt-4">
                    <b class="text-center" style="font-size:18px;">Are you sure want to Delete ? </b>
                </div>
                <div class="row mt-3 mb-1 d-flex justify-content-between">
                    <button class="btn btn-success ms-5" id="delete" value="" style="width:90px;">Delete</button>
                    <button class="btn btn-danger me-5" data-bs-dismiss="modal" style="width:90px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('jquery/autoFill.js') }}"></script>
    <script src="{{ asset('jquery/active.js') }}"></script>
    <script src="{{ asset('jquery/inactive.js') }}"></script>
    <script src="{{ asset('jquery/itemDownload.js') }}"></script>
    <script src="{{ asset('jquery/itemDelete.js') }}"></script>
    <script src="{{ asset('jquery/autoComplete.js') }}"></script>

@endpush
