@extends('layouts.layout')

@section('page-title')
    Home Page | Explore Events!
@endsection

@section('content')
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-6 fw-bold text-body-emphasis">The Easiest and Most Powerful<br>Online Event Booking and Ticketing System</h1>
        <div class="col-lg-8 mx-auto">
            <p class="lead mb-4">Explore Events! is an all-in-one event ticketing platform for event organisers, promoters, and managers. Easily create, promote and manage your events of any type and size.</p>
            <div class="d-grid gap-2 d-flex justify-content-center">
                <form class="w-100 me-3" role="search">
                    <input type="search" class="form-control form-control-lg" placeholder="Type here to search..." aria-label="Search" id="search-input">
                </form>

                <div class="flex-shrink-0">
                    <a type="button" class="btn btn-lg btn-primary" id="search-btn">Search</a>
                </div>
            </div>
        </div>
    </div>

    <p class="d-inline-flex gap-1">
        <a type="button" class="btn btn-light me-4" href="{{ route('home.index') }}">All</a>
        @foreach($categories as $category)
            <button type="button" class="btn btn-light cat-btn" data-bs-toggle="button" value="{{ $category->id }}">{{ $category->name }}</button>
        @endforeach
    </p>

    @if(count($events))
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-3">
            @foreach($events as $event)
                <div class="col">
                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('storage/images/events/'.$event->image) }}'); background-repeat: no-repeat; background-position: center; background-size: cover;">
                        <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                            <h3 class="pt-5 mt-5 mb-4 fs-5 lh-1 fw-bold"><a class="text-white text-decoration-none" href="{{ route('home.show-event', $event) }}">{{ $event->title }}</a></h3>
                            <ul class="d-flex d-lg-block d-xl-flex list-unstyled mt-auto">
                                <li class="me-auto d-flex flex-column gap-2 mb-lg-2 mb-xl-0">
                                    @foreach($event->categories as $category)
                                        <span class="badge text-bg-light fw-medium">{{ $category->name }}</span>
                                    @endforeach</li>
                                <li class="d-flex align-items-center me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-calendar4-event me-2" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                    <small>{{ date('j M Y',strtotime($event->start_date)) }}</small>
                                </li>
                                <li class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"></path>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"></path>
                                    </svg>
                                    <small>{{ date('H:i',strtotime($event->start_date)) }}</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No Results</p>
    @endif

    {{ $events->links() }}
@endsection

@section('custom-js')
    <script>
        let searchQuery = '';
        let categoriesQuery = '';

        const catBtns = document.querySelectorAll(".cat-btn");
        const searchInput = document.getElementById("search-input");
        const searchBtn = document.getElementById("search-btn");

        window.addEventListener('load', (event) => {
            // При загрузке страницы необходимо разобрать URL и отметить нужные категории
            let queryParams = (new URL(document.location)).searchParams;

            if (queryParams.has('search')) {
                searchQuery = queryParams.get('search');
                searchInput.value = searchQuery;
            }

            if (queryParams.has('categories')) {
                let categoriesQueryComma = queryParams.get('categories');
                categoriesQuery = categoriesQueryComma.split(',');

                for (let i = 0; i < categoriesQuery.length; i++) {
                    for (let j = 0; j < catBtns.length; j++) {
                        if (categoriesQuery[i] == catBtns[j].value) {
                            catBtns[j].classList.add('active');
                        }
                    }
                }
            }
        });

        searchBtn.addEventListener('click', updateFilter);
        searchInput.addEventListener("keyup", function(e) {
            e.preventDefault();
            if (e.keyCode === 13) {
                updateFilter();
            }
        });

        for (let i = 0; i < catBtns.length; i++) {
            catBtns[i].addEventListener('click', updateFilter);
        }


        function updateFilter() {
            searchQuery = searchInput.value;

            categoriesQuery = '';
            for ( let i = 0; i < catBtns.length; i++ ) {
                if (catBtns[i].classList.contains('active')) {
                    categoriesQuery = categoriesQuery + catBtns[i].value + ',';
                }
            }
            categoriesQuery = categoriesQuery.slice(0, -1);

            updatePage();
        }

        // Обновление страницы
        function updatePage() {
            let newLink = window.location.origin + window.location.pathname;
            if (categoriesQuery !== '' || searchQuery !== '') {
                newLink = newLink + '?';
                if (categoriesQuery !== '') { newLink = newLink + 'categories=' + encodeURIComponent(categoriesQuery) + '&' }
                if (searchQuery !== '') { newLink = newLink + 'search=' + searchQuery + '&' }
                newLink = newLink.slice(0, -1);
            }
            window.location.href = newLink;
        }
    </script>
@endsection