@extends('dashboard.layouts.main')

@section('container')
<div id="container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="btn-group">
      <h1 class="h2">{{ $type }}, {{ $name }}</h1>
    </div>
    <!-- Example single danger button -->
    @if (isset($participants))
      <div class="btn-group">
        {{-- <button class="btn btn-warning" id="send-email">Kirim Email</button>
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          {{ $filter }}
        </button>
        <ul class="dropdown-menu">
          @if ($filter == "Done")
            <li><a href="/dashboard/participants-{{ $slug }}" class="dropdown-item">All</a></li>
            <li><a href="/dashboard/teams-ajax?status=pending&id_lomba={{ $competition }}&slug={{ $slug }}" class="dropdown-item">Pending</a></li>
          @elseif($filter == "Pending")
            <li><a href="/dashboard/participants-{{ $slug }}" class="dropdown-item">All</a></li>
            <li><a href="/dashboard/teams-ajax?status=done&id_lomba={{ $competition }}&slug={{ $slug }}" class="dropdown-item">Done</a></li>
          @else
            <li><a href="/dashboard/teams-ajax?status=pending&id_lomba={{ $competition }}&slug={{ $slug }}" class="dropdown-item">Pending</a></li>
            <li><a href="/dashboard/teams-ajax?status=done&id_lomba={{ $competition }}&slug={{ $slug }}" class="dropdown-item">Done</a></li>
          @endif --}}
          {{-- @if ($filter == "Done")
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">All</button></li>
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">Pending</button></li>
          @elseif($filter == "Pending")
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">All</button></li>
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">Done</button></li>
          @else
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">Pending</button></li>
            <li><button class="dropdown-item" data-competition="{{ $competition }}" data-abbreviation="{{ $slug }}">Done</button></li>
          @endif --}}
        </ul>
      </div>
    @endif
  </div>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  @if (count($tickets) > 0)
    <div class="container">
      <div class="row">
        @foreach ($tickets as $ticket)
        <div class="col-md-3 mb-3">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">{{ $ticket->nama_tim }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $ticket->lomba->nama_lomba }}</h6>
                <p class="card-text">{{ $ticket->created_at->toFormattedDateString() }}</p>
                <span class="mt-3 d-block fw-semibold">{{ $kode . "-" . str_pad($ticket->user_id, 4, "0", STR_PAD_LEFT) . str_pad($ticket->id, 4, "0", STR_PAD_LEFT) . str_pad($ticket->id_lomba, 4, "0", STR_PAD_LEFT) }}</span>
                <button class="badge bg-warning mt-3 border-0 fs-6 btn-payment" data-token="{{ $ticket->token }}" data-team-id="{{ $ticket->id }}">BNI VA</button>
                <button class="badge bg-primary mt-3 border-0 fs-6 btn-payment" data-token="{{ $ticket->token }}"  data-team-id="{{ $ticket->id }}">BCA VA</button>
                <button class="badge bg-success mt-3 border-0 fs-6 btn-payment" data-token="{{ $ticket->token }}"  data-team-id="{{ $ticket->id }}">BRI VA</button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>


    {{-- MODAL --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Metode Pembayaran</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group fs-6">
              <li class="list-group-item">Metode Pembayaran : <span class="pay-method fw-semibold"></span></li>
              <li class="list-group-item">Nomor VA <span class="type-bank text-uppercase"></span>: </li>
              <li class="list-group-item fw-semibold"><span class="va-number d-inline-block me-2"></span></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Sudah Bayar</button>
          </div>
        </div>
      </div>
    </div>
    {{-- TUTUP MODAL --}}

    {{-- MODAL --}}
    <div class="modal fade" id="loading" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- TUTUP MODAL --}}


  @else
    <p class="text-center fs-4">No tickets found.</p>  
  @endif
</div>


@endsection