@extends('components.partails')
@section('content')
    @include('admin.dashboard.navbar')
    @include('admin.dashboard.sidebar')
    <div class="p-4 sm:ml-64">

        @foreach ($product as $product)

        <div class="overflow-y-auto shadow-md sm:rounded-lg">
            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="{{asset('storage/products/'.$product->image)}}">
                    <img class="rounded-t-lg" src="{{asset('storage/products/'.$product->image)}}" alt="" />
                </a>
                <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$product->name}}</h5>

                        <div class="flex justify-between">
                            <span class=" font-normal text-gray-700 dark:text-gray-400">${{$product->price}}</span>
                            <span class=" font-normal text-gray-700 dark:text-gray-400">Left In Stock {{$product->quantity}}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class=" font-normal text-gray-700 dark:text-gray-400"><strong>Category:</strong></span>

                            <span class=" font-normal text-gray-700 dark:text-gray-400">{{$product->category->name}}</span>
                        </div>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$product->description}}</p>
                </div>
            </div>

            @endforeach

        </div>
    </div>
@endsection
