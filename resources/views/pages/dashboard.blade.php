{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}


          <div class="row">
      <div class="col-md-3">
          <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover  " style="height: 130px;  ">
              <!--begin::Body-->
              <div class="card-body d-flex flex-column">
                  <!--begin::Title-->
                  <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h3">{{__('Workers')}}</a>
                  <div class="py-3 m-0 text-center count h1  text-info">
                      {{$worker}}
                  </div>
                  <!--end::Title-->
              </div>
              <!--end::Body-->
          </div>
      </div>
      {{-- /.col-md-3 --}}
      <div class="col-md-3">
          <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover  " style="height: 130px; ">
              <!--begin::Body-->
              <div class="card-body d-flex flex-column">
                  <!--begin::Title-->
                  <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h3">{{__('Contractor')}}</a>
                  <div class="py-3 m-0 text-center count h1  text-info">
                      {{$contractor}}
                  </div>
                  <!--end::Title-->
              </div>
              <!--end::Body-->
          </div>
      </div>
      {{-- /.col-md-3 --}}
      <div class="col-md-3">
          <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover  " style="height: 130px;">
              <!--begin::Body-->
              <div class="card-body d-flex flex-column">
                  <!--begin::Title-->
                  <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h3">{{__('Jobs')}}</a>
                  <!--end::Title-->
                  <div class="py-3 m-0 text-center count h1  text-info">
                      {{$job}}
                  </div>
              </div>
              <!--end::Body-->
          </div>
      </div>
      {{-- /.col-md-3 --}}
      <div class="col-md-3">
          <div class="card card-custom bgi-no-repeat bgi-no-repeat bgi-size-cover  " style="height: 130px; ">
              <!--begin::Body-->
              <div class="card-body d-flex flex-column">
                  <!--begin::Title-->
                  <a class="text-dark-75 text-hover-primary font-weight-bolder font-size-h3">{{__('Tenders')}}</a>
                  <div class="py-3 m-0 text-center count h1  text-info">
                      {{$tender}}
                  </div>
                  <!--end::Title-->
              </div>
              <!--end::Body-->
          </div>
      </div>
      {{-- /.col-md-3 --}}

  </div>
  <br>
   <div class="row">
        <div class="col-lg-12 col-xxl-12">
            @include('pages.widgets._widget-2', ['class' => 'card-stretch gutter-b'])
        </div>

        {{-- <div class="col-lg-6 col-xxl-4">
            @include('pages.widgets._widget-3', ['class' => 'card-stretch card-stretch-half gutter-b'])
            @include('pages.widgets._widget-4', ['class' => 'card-stretch card-stretch-half gutter-b'])
        </div>

        <div class="col-lg-6 col-xxl-4 order-1 order-xxl-1">
            @include('pages.widgets._widget-5', ['class' => 'card-stretch gutter-b'])
        </div>

        <div class="col-xxl-8 order-2 order-xxl-1">
            @include('pages.widgets._widget-6', ['class' => 'card-stretch gutter-b'])
        </div>

        <div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
            @include('pages.widgets._widget-7', ['class' => 'card-stretch gutter-b'])
        </div>

        <div class="col-lg-6 col-xxl-4 order-1 order-xxl-2">
            @include('pages.widgets._widget-8', ['class' => 'card-stretch gutter-b'])
        </div>

        <div class="col-lg-12 col-xxl-4 order-1 order-xxl-2">
            @include('pages.widgets._widget-9', ['class' => 'card-stretch gutter-b'])
        </div>
    </div> --}}

@endsection

{{-- Scripts Section --}}
@section('scripts')
  <meta name="csrf-token" content="{{ csrf_token() }}" />
    @csrf
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection
