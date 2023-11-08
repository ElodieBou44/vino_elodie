@extends('layouts.app')
@section('title','Recherche')
@section('content')

<body>
        <header>
            ajouter une bouteille
        </header>
        <main class="nav-margin">
            <section class="form-ajouter-bouteille"> <!-- encadré noir (formulaires, filtres et tris) --> 
                <div class="form-container">
                    <form action="{{ route('bouteille.search') }}" method="GET" id="searchForm">
                        <!-- @csrf -->
                        <div class="form-input-container">
                            <label for="search">RECHERCHE</label>
                            <input type="text" id="search" name="search">
                        </div>
                    </form>
                    
                </div>
                <div class="link link-right">
                    <a href="#">BOUTEILLE PERSONNALISÉE</a>
                </div>
                <div class="form-container">
                    <form action="{{ route('filtrer_produits') }}" method="" id="">
                        <hr>
                        <details>
                            <summary>Filtrer</summary>
                            <div class="form-input-container">
                                <label for="coleur">Couleur</label>
                                <select name="couleur" id="couleur">
                                    <option value="">Choisir les options</option>
                                    <option value="Blanc">Blanc</option>
                                    <option value="Rouge">Rouge</option>
                                    <option value="Rosé">Rosé</option>
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="format">Format</label>
                                <select name="format" id="format">
                                    <option value="">Choisir les options</option>
                                    <option value="250">250ml</option>
                                    <option value="750">750ml</option>
                                    <option value="1L">1L</option>
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="prix">Prix</label>
                                <!-- <span>Erreur prix</span> -->
                                <div>
                                    <div>
                                        <label for="prix_min">Minimum</label>
                                        <input name="prix_min"  id="prix_min" type="number">
                                    </div>
                                    <div>
                                        <label for="prix_max">Maximum</label>
                                        <input name="prix_max"  id="prix_max" type="number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-input-container">
                                <label for="country">Pays</label>
                                <select name="pays" id="pays">
                                    <option value="">Choisir les options</option>
                                    <option value="canada">Canada</option>
                                    <option value="usa">États-Unis</option>
                                    <option value="espagne">Espagne</option>
                                    <option value="france">France</option>
                                    <option value="italie">Italie</option>
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="region">Région</label>
                                <select name="region" id="region">
                                    <option value="">Choisir les options</option>
                                    <option value="quebec">Québec</option>
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="millesime">Millésime</label>
                                <select name="millesime" id="millesime">
                                    <option value="">Choisir les options</option>
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                            <div class="form-input-container">
                                <label for="grape">Cépage</label>
                                <select name="grape" id="grape">
                                    <option value="">Choisir les options</option>
                                    <option value="cabernet-sauv">Cabernet-Sauvignon</option>
                                </select>
                            </div>
                        </details>                        
                        <div class="tag-container"></div>
                        <button type="submit">Filtrer</button>
                    </form>
                </div>
                <div class="form-container">
                    <hr>
                    <form action="{{ route('bouteille.sorting') }}" method="GET" id="sortingForm">
                        <!-- @csrf -->
                        <div class="form-input-container">
                            <label for="sort">TRIER</label>
                            <select name="sort" id="sort">
                                <option value="defaut" {{ request('sorter') == 'defaut' ? 'selected' : '' }}></option>

                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nom du produit (A-Z)</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nom du produit (Z-A)</option>
                                <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Prix ($-$$$)</option>
                                <option value="price-desc" {{ request('sortt') == 'price-desc' ? 'selected' : '' }}>Prix ($$$-$)</option>
                            </select>
                        </div>
                    </form>
                </div>
            </section>
            <div class="card-count">
                {{-- <p>{{$bouteilles->total()}} bouteilles :</p> --}}
            </div>
            @foreach ($bouteilles as $bouteille)
            <section class="card-bouteille">
                <picture>
                    <img src="{{ $bouteille->srcImage }}" alt="{{ $bouteille->nom}}">
                </picture>
                <div class="card-bouteille-content">
                    <div class="card-bouteille-info">
                       
                            <h2><a href="{{ route('bouteille.show',['bouteille_id'=> $bouteille->id]) }}" class="bottle-link">{{ $bouteille->nom }}</a></h2>
                      
                        <span>{{$bouteille->type}} | {{ $bouteille->format }} | {{$bouteille->pays}}</span>
                        <p>{{$bouteille->prix}} $</p>
                    </div>
                    <a href="" class="btn-ajouter">+ Ajouter</a>
                </div>
            </section>
          
            @endforeach  
             {{ $bouteilles->links() }}
        </section>
    </main>
    @endsection

            <!-- <div class="modal-container"> -->
                <dialog id="modal-ajouter" class="modal">
                        <h2>Confirmation d'ajout</h2>
                        <hr>
                        <form action="" class="form-modal">
                                <div class="form-radio">
                                    <input type="radio" id="location-cellier" name="location" checked >
                                    <label for="location-cellier">Celliers</label><br>
                                </div>
                                <div class="form-radio">
                                    <input type="radio" id="location-liste" name="location">
                                    <label for="location-liste">Listes</label>
                                </div>
                                <div class="form-input-container">
                                    <label for="cellier-location">Millésime</label>
                                    <select name="cellier-location" id="cellier-location">
                                        <option value="">Maison</option>
                                        <option value="">Cottage</option>
                                        <option value="">Bureau</option>
                                    </select>
                                </div>
                                <div class="card-bouteille-qt">
                                    <button class="btn-decrement">-</button>
                                    <input type="text" value="1" min="1" readonly>
                                    <button class="btn-increment">+</button>
                                </div>
                                <div class="btn-modal-container">
                                    <button class="btn-modal-action">ajouter</button>
                                    <button class="btn-modal-cancel">annuler</button>
                                </div>
                        </form>
                </dialog>
            <!-- </div> -->
          
            <script src="../../js/bottleCounterModal.js"></script>
            <script src="../../js/modalAjouter.js"></script>
            <script src="../../js/filterTag.js"></script>
             <script src="../../js/sorting.js"></script>  
             {{-- <script src="{{asset('assets/js/sorting.js')}}" ></script>   --}}

           
        </main>
     
         {{-- tri a deplacer dans le dossier js --}}
        {{-- <script>
            document.getElementById('sort').addEventListener('change', function() {
                document.getElementById('sortingForm').submit();
            });
        </script>   --}}

       
        
    {{-- <nav class="nav">
        <ul class="nav-list">
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container nav-active">
                        <img src="../../../public/assets/icons/home_icon.svg" alt="Accueil">
                        <figcaption>accueil</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/add_icon.svg" alt="Recherche">
                        <figcaption class="icons-label">ajouter</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/list_icon.svg" alt="Liste d'achats">
                        <figcaption>liste</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">        
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/cellars_icon.svg" alt="Celliers">
                        <figcaption>celliers</figcaption>
                    </figure>
                </a>
            </li>
            <li class="nav-item">         
                <a href="#">
                    <figure class="nav-icon-container">
                        <img src="../../../public/assets/icons/profile_icon.svg" alt="Profil">
                        <figcaption>profil</figcaption>
                    </figure>
                </a>
            </li>
        </ul>
    </nav>
</body>
</html> --}}
