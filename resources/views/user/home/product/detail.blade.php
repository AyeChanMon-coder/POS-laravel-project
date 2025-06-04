@extends('user.layouts.master')
@section('content')
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <a href="{{ route('user#home') }}"> Home </a> <i class=" mx-1 mb-4 fa-solid fa-greater-than"></i> Details
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="">
                                    <img src="{{ asset('productImages/' . $item->image) }}" class="img-fluid rounded"
                                        alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold">{{ $item->name }}</h4>
                            <span class="text-danger mb-3">({{ $item->stock }} items left ! )</span>
                            <p class="mb-3">Category: {{ $item->category_name }}</p>
                            <h5 class="fw-bold mb-3">{{ $item->price }} mmk</h5>
                            <div class="d-flex mb-4">
                                <span class="">
                                    @for ($i = 1; $i <= $avg_rating; $i++)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @endfor
                                    @for ($j = $avg_rating + 1; $j <= 5; $j++)
                                        <i class="fa-regular fa-star text-warning"></i>
                                    @endfor
                                </span>

                                {{-- <span class=" ms-4">
                                    <i class="fa-solid fa-eye"></i>
                                </span> --}}

                            </div>
                            <p class="mb-4"></p>
                            <form action="{{ route('cart#create') }}" method="post">
                                @csrf
                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="productId" value="{{ $item->id }}">
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="count"
                                        class="form-control form-control-sm text-center border-0" value="1"
                                        max="{{ $item->stock }}">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                        class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                        class="fa-solid fa-star me-2 text-secondary"></i> Rate this product</button>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Rate this product
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user#rating') }}" method="post">
                                            @csrf
                                            <div class="modal-body">

                                                <input type="hidden" name="productId" value="{{ $item->id }}">

                                                <div class="rating-css">
                                                    <div class="star-icon">
                                                        <input type="radio" value="1" name="productRating" checked
                                                            id="rating1">
                                                        <label for="rating1" class="fa fa-star"></label>

                                                        <input type="radio" value="2" name="productRating"
                                                            id="rating2">
                                                        <label for="rating2" class="fa fa-star"></label>

                                                        <input type="radio" value="3" name="productRating"
                                                            id="rating3">
                                                        <label for="rating3" class="fa fa-star"></label>

                                                        <input type="radio" value="4" name="productRating"
                                                            id="rating4">
                                                        <label for="rating4" class="fa fa-star"></label>

                                                        <input type="radio" value="5" name="productRating"
                                                            id="rating5">
                                                        <label for="rating5" class="fa fa-star"></label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Rating</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-about" aria-controls="nav-about"
                                        aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Customer Comments <span
                                            class=" btn btn-sm btn-secondary rounted shadow-sm">{{ count($comment) }}</span>

                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    <p>{{ $item->description }}</p>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                    aria-labelledby="nav-mission-tab">

                                    @foreach ($comment as $message)
                                        <div class="d-flex">
                                            <img src="{{ $message->profile ? asset('profile/' . $message->profile) : asset('default/profilePic.jpg') }}"
                                                class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;">
                                            <div class="">
                                                <span
                                                    class="text-muted">{{ $message->created_at->format('j - F - Y') }}</span>
                                                <div class="d-flex justify-content-between">
                                                    <h5>
                                                        {{ $message->user_name }}
                                                    </h5>
                                                    @if (Auth::user()->name == $message->user_name)
                                                        <div class="justify_content-end">
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="deleteProcess({{ $message->id }})"><i
                                                                    class="fa-solid fa-trash"></i></button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr>


                                </div>

                            </div>
                        </div>
                        <form action="{{ route('user#productComment') }}" method="post">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $item->id }}">
                            <h4 class="mb-5 fw-bold">
                                Leave a Comments
                            </h4>

                            <div class="row g-1">
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded ">
                                        <textarea name="comment" id="" class="form-control border-0 shadow-sm" cols="30" rows="8"
                                            placeholder="Your Review *" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between py-3 mb-5">
                                        <button type="submit"
                                            class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                            Post
                                            Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-script')
    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = '/user/product/commentDelete/' + $id
                    }, 2000);
                }
            });
        }
    </script>
@endsection
