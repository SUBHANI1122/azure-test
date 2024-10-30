@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row pb-2">
            <div class="col-md-12 px-0">
                <div class="card border-0 rounded-0">
                    <div class="card-header bg-success text-white rounded-0 py-3">
                        {{ __('Export') }}
                        <button type="button" class="btn text-white btn-lg mobile-menu">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 pt-5">
            <a href="{{route('exportTickets')}}">
                <button type="button" class="btn btn-success  btn-md float-end">Export All Data</button>
            </a>
        </div>
        <div class="col-md-8 col-lg-7">
            <form action="{{route('exportTickets')}}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="from">From</label>
                        <input type="date" class="form-control" id="from_date" placeholder="From Date" name="from_date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">To</label>
                        <input type="date" class="form-control" id="to_date" placeholder="To Date" name="to_date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Type</label>
                        <select class="form-control" name="type" id="" >
                            <option value="" selected disabled>Please Select Any Type</option>
                            <option value="Medical Care & Physiotherapy Clinic">Medical Care & Physiotherapy Clinic</option>
                            <option value="Dinner Dance">Dinner Dance</option>
                        </select>
                    </div>
                </div>

                <div>
                <div class="mt-3">
                <button type="submit" class="btn btn-success float-end">Search</button>
                </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
