<nav class="FilterBar navbar navbar-expand-lg bg-light border-bottom mb-4">
        <div class="container-md">
            
            <form class="FilterBar-search row d-flex flex-wrap w-100 gap-2 align-content-around" role="search">
                <!-- Filter Options -->
                <div class="col d-flex align-items-center gap-2">
                    <Button class="btn btn-primary">Filter</Button>

                    <select class="form-select me-2" aria-label="Filter by make">
                        <option selected>All Makes</option>
                        <option value="1">Lamborghini</option>
                        <option value="2">Ferrari</option>
                        <option value="3">Porsche</option>
                    </select>

                    <select class="form-select me-2" aria-label="Filter by make">
                        <option selected>All Models</option>
                        <option value="1">Lamborghini</option>
                        <option value="2">Ferrari</option>
                        <option value="3">Porsche</option>
                    </select>

                    <select class="form-select me-2" aria-label="Filter by price">
                        <option selected>Any Price</option>
                        <option value="1">Under $100,000</option>
                        <option value="2">$100,000 - $250,000</option>
                        <option value="3">Over $250,000</option>
                    </select>
                </div>

                <!-- Search Bar -->
                <div class="col d-flex align-items-center gap-2 w-50">
                    <input class="form-control me-2" type="search" placeholder="Search vehicles..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <button class="btn btn-outline-secondary" type="button">Reset</button>
                </div>

            </form>
        </div>
    </nav>
