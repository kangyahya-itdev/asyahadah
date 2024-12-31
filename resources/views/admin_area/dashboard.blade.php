@extends('layouts.admin')
@section('content')
<main>
    <div class="container">
      <div class="row">
        <!-- DASHBOARD -->
        <div class="col s12 l12 dashboard">
          <div class="card grey lighten-3">
            <div class="card-content posts">
              <!-- EVENTS HEADER & SEARCH BAR -->
              <nav class="red darken-1">
                <div class="nav-wrapper">
                  <h4 class="left event-title">EVENTS</h4>
                  <form class="search-field right">
                    <div class="input-field">
                      <input id="search" type="search" required>
                      <label class="label-icon search-icon" for="search"><i class="material-icons">search</i></label>
                      <i class="material-icons close-icon">close</i>
                    </div>
                  </form>
                </div>
              </nav>
              <!-- END_EVENTS HEADER & SEARCH BAR -->
              <div class="card medium event-card">
                <div class="card-image">
                  <img src="https://images.pexels.com/photos/1081912/pexels-photo-1081912.jpeg?cs=srgb&dl=agriculture-bird-s-eye-view-colors-1081912.jpg&fm=jpg" alt="banner">
                </div>
                <div class="card-content">
                  <div class="card-title"><b>Event Title</b></div>
                  <div class="left">
                    <p>01/10/2019 - USA</p>
                    <p><a href="#">View Details</a></p>
                  </div>
                  <div class="right-align">
                    <button class="waves-effect waves-light btn"><i class="material-icons left">add</i>Join</button>
                    <p><b>Capacity: </b> 3/100</p>
                  </div>
                </div>
              </div>
              <div class="card medium event-card">
                <div class="card-image">
                  <img src="https://images.pexels.com/photos/1853371/pexels-photo-1853371.jpeg?cs=srgb&dl=adventure-cliff-daylight-1853371.jpg&fm=jpg" alt="banner">
                </div>
                <div class="card-content">
                  <div class="card-title"><b>Event Title</b></div>
                  <div class="left">
                    <p>01/10/2019 - USA</p>
                    <p><a href="#">View Details</a></p>
                  </div>
                  <div class="right-align">
                    <button class="waves-effect waves-light btn"><i class="material-icons left">add</i>Join</button>
                    <p><b>Capacity: </b> 3/100</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END_DASHBOARD -->
      </div>
    </div>
  </main>
  @endsection