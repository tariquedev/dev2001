@extends('frontend.master')
@section('blogs')
active    
@endsection

@section('content')
    <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Blog</h2>
                        <ul>
                            <li><a href="{{ route('front') }}">Home</a></li>
                            <li><span>Blog</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- blog-area start -->
    <div class="blog-area">
        <div class="container">
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Latest News</h2>
                    <img src="assets/images/section-title.png" alt="">
                </div>
            </div>
            <div class="row">
                @foreach ($blogs as $item)
                <div class="col-lg-4  col-md-6 col-12">
                    <div class="blog-wrap">
                        <div class="blog-image">
                            <img src="{{ asset('images/thumbnail/'.$item->created_at->format('Y/m/').$item->id.'/'.$item->thumbnail) }}" alt="{{ $item->title }}">
                            <ul>
                                <li>{{ $item->created_at->format('d') }}</li>
                                <li>{{ $item->created_at->format('M') }}</li>
                            </ul>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#"><i class="fa fa-user"></i> {{ $item->user->name }}</a></li>
                                    <li class="pull-right"><a href="#"><i class="fa fa-clock-o"></i> {{ $item->created_at->format('d/m/Y') }}</a></li>
                                </ul>
                            </div>
                            <h3><a href="{{ route('SingleBlog', $item->slug)  }}">{{ $item->title }}</a></h3>
                            <p>
                                {!! Str::limit($item->summary, 180,'......') !!}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-12">
                    <div class="pagination-wrapper text-center mb-30">
                        {{-- {{ $blogs->links() }} --}}
                        @if ($blogs->lastPage() > 1)
                            
                        
                        <ul class="page-numbers">
                            <li><a class="prev page-numbers {{ $blogs->currentPage() == 1 ? 'disabled' : '' }}" href="{{ $blogs->url(1) }}"><i class="fa fa-arrow-left"></i></a></li>
                            @for ($i = 1; $i <= $blogs->lastPage(); $i++)
                                <li class="rabbi {{ $blogs->currentPage() == $i ? 'current' : '' }}">
                                    <a class="page-numbers" href="{{ $blogs->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                               
                            <li><a class="next page-numbers {{ $blogs->currentPage() == $blogs->lastPage() ? 'disabled' : '' }}" href="{{ $blogs->url($blogs->currentPage() +1) }}"><i class="fa fa-arrow-right"></i></a></li>
                        </ul>
                        @endif

                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-area end -->
@stop