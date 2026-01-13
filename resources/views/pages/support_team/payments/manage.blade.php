@extends('layouts.master')
@section('page_title', 'Student Payments')
@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-cash2 mr-2"></i> Student Payments</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('payments.select_class') }}">
                @csrf
              <div class="row">
                  <div class="col-md-8 offset-md-2">
                      <div class="row">
                          <div class="col-md-5">
                              <div class="form-group">
                                  <label for="my_class_id" class="col-form-label font-weight-bold">Class:</label>
                                  <select required id="my_class_id" name="my_class_id" class="form-control select">
                                      <option value="">Select Class</option>
                                      @foreach($my_classes as $c)
                                          <option {{ ($selected && isset($my_class_id) && $my_class_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-5">
                              <div class="form-group">
                                  <label for="year" class="col-form-label font-weight-bold">Academic Year:</label>
                                  <select required id="year" name="year" class="form-control select">
                                      <option value="">Select Year</option>
                                      @foreach($years as $yr)
                                          <option {{ (isset($selected_year) && $selected_year == $yr) || (!isset($selected_year) && $current_year == $yr) ? 'selected' : '' }} value="{{ $yr }}">{{ $yr }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-2 mt-4">
                              <div class="text-right mt-1">
                                  <button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>

            </form>
        </div>
    </div>
    @if($selected)
        <div class="card">
            <div class="card-body">
                <table class="table datatable-button-html5-columns">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>ADM_No</th>
                        <th>Payments</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $s->user->photo }}" alt="photo"></td>
                            <td>{{ $s->user->name }}</td>
                            <td>{{ $s->adm_no }}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class=" btn btn-danger" data-toggle="dropdown"> Manage Payments <i class="icon-arrow-down5"></i>
                                    </a>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a href="{{ route('payments.invoice', [Qs::hash($s->user_id)]) }}" class="dropdown-item">All Payments</a>
                                @if(isset($selected_year))
                                    <a href="{{ route('payments.invoice', [Qs::hash($s->user_id), $selected_year]) }}" class="dropdown-item">{{ $selected_year }}</a>
                                @endif
                                @foreach(Pay::getYears($s->user_id) as $py)
                                @if($py && (!isset($selected_year) || $py != $selected_year))
                                    <a href="{{ route('payments.invoice', [Qs::hash($s->user_id), $py]) }}" class="dropdown-item">{{ $py }}</a>
                                @endif
                                @endforeach
                            </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
