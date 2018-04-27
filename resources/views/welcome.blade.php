@extends('layouts.app')
@section('title','Shopping Now')
@section('jumbotron')
  <div class="jumbotron" style="background-image: url({{ asset('image/Books.jpg') }});">
    <div class="container text-center" >
      <h1>Online Store</h1>      
      <p>Selling Good Books! Buy Now ..</p>
    </div>
  </div>
@endsection
@section('content')
      @if(Session::has('success_message'))
      <div class="container-fluid text-center alert alert-success">{{ Session::get('success_message') }}</div>
    @endif
<div class="container-fluid">
  <div class="row content">
      <div class="col-sm-3 sidebar">
          <div class="well" style="border-left: 3px solid gray;">
            <h3>Filters</h3>
            <ul>
              <li><a href="{{ route('index',['price'=>'less10']) }}">less than 10</a></li>
              <li><a href="{{ route('index',['price'=>'10to100']) }}">equal 10 to 100 $</a></li>
              <li><a href="{{ route('index',['price'=>'morethan100']) }}">more than 100$</a></li>
            </ul>
            <h3>Categories</h3>
            <ul>
              @foreach($categories as $category)
              <li><a href="{{ route('index',['category'=>$category->slug]) }}">{{ $category->name }}</a></li>
              @endforeach
            </ul>
          </div>
      </div>
      <BR>
      <div class="col-sm-9 col-md-9" style="border-left: 3px solid gray;">
        @if($products->isNotEmpty())
        @foreach($products as $product)

          <div class="col-sm-6 col-md-4">
            <div class="panel panel-primary">
              <div class="panel-heading">{{ $product->name }}</div>
              <div class="panel-body">
                <img src="../public{{Storage::url($product->image)}}" class="img-responsive" style="width:100%;height: 200px;" alt="Image">
              </div>
              <div class="panel-footer">{{ str_limit($product->description,20,"...") }}

                <!-- Trigger the modal with a button -->
                <a type="button" class="btn"  data-toggle="modal" data-target="#myModal">Read More</a>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">More Details for {{ $product->name }} </h4>
                      </div>
                      <div class="modal-body">
                        <p> {{ $product->description }} </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>


                <BR><BR>
                <center>
                  <a class="btn btn-plane btn-default" href="{{ route('product.addToCard',[$product->id]) }}">{{ $product->presentPrice() }}<span class="glyphicon glyphicon-shopping-cart"></span></a></center>
              </div>
            </div>
          </div>
        @endforeach
        @else
        <h1 class="alert alert-danger">No Result To Show !!</h1>
        @endif
      </div>
  </div>
</div>

<br><br>
@endsection
@section('footer')
@include('layouts.footer')
@endsection


