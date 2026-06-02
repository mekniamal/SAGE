@extends('layouts.luxury-app')

@section('title', 'Sage - Accueil')

@section('content')

<style>
    .home-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 4rem;
        padding: 6rem 4rem;
        max-width: 1400px;
        margin: 0 auto;
    }
    .home-hero-text h1 {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
    }
    .home-hero-text p {
        font-size: 1.2rem;
        color: #888;
        margin-bottom: 2rem;
        line-height: 1.8;
    }
    .home-btn {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: #4a5d4a;
        color: white;
        text-decoration: none;
        border-radius: 2px;
        transition: all 0.3s;
        font-size: 1.1rem;
        font-family: 'Cormorant Garamond', serif;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .home-btn:hover {
        background: #3d4a3d;
        transform: translateY(-2px);
    }
    .home-image {
        width: 100%;
        aspect-ratio: 3 / 4;
        max-height: 520px;
        border-radius: 0;
        overflow: hidden;
    }
    .home-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .home-stats {
        background: #2c2c2c;
        color: white;
        padding: 4rem 2rem;
        margin: 4rem 0 0 0;
    }
    .home-stats-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
        text-align: center;
    }
    .stat-item h3 {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        color: #4a5d4a;
        font-family: 'Cormorant Garamond', serif;
    }
    .stat-item p {
        font-size: 1rem;
        color: #ccc;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }
    
    .home-about {
        max-width: 1400px;
        margin: 6rem auto;
        padding: 0 4rem;
    }
    .home-about h2 {
        font-size: 2.8rem;
        margin-bottom: 3rem;
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
    }
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .about-text p {
        font-size: 1rem;
        color: #888;
        margin-bottom: 1.5rem;
        line-height: 1.9;
    }
    .about-image {
        width: 100%;
        min-height: 380px;
        aspect-ratio: 4 / 5;
        max-height: 480px;
        overflow: hidden;
        border-radius: 0;
    }
    .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }
    
    @media (max-width: 768px) {
        .home-hero, .about-grid, .home-stats-container {
            grid-template-columns: 1fr;
            padding: 2rem 1.5rem;
            gap: 2rem;
        }
        .home-hero-text h1 {
            font-size: 2rem;
        }
        .home-stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Hero Section -->
<section class="home-hero">
    <div class="home-hero-text">
        <h1>L'art du naturel au quotidien</h1>
        <p>Découvrez notre collection exclusive de produits cosmétiques haut de gamme, conçus avec les meilleurs ingrédients naturels pour votre bien-être et votre beauté.</p>
        <a href="{{ route('shop') }}" class="home-btn">Découvrir la boutique</a>
    </div>
    <div class="home-image">
        <img src="{{ asset('images/arriere-plan-accueil.png') }}" alt="Collection cosmétique naturelle">
    </div>
</section>

@include('layouts.partials.trust-marquee')

<!-- Stats Section -->
<section class="home-stats">
    <div class="home-stats-container">
        <div class="stat-item">
            <h3>{{ $stats['products'] ?? 0 }}</h3>
            <p>Produits</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['categories'] ?? 0 }}</h3>
            <p>Catégories</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['clients'] ?? 0 }}</h3>
            <p>Clients</p>
        </div>
        <div class="stat-item">
            <h3>100%</h3>
            <p>Naturel</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="home-about">
    <h2>À propos de Sage</h2>
    <div class="about-grid">
        <div class="about-text">
            <p>
                Sage est une boutique dédiée à la beauté naturelle et au bien-être. Nous sélectionnons les meilleurs produits cosmétiques et de soins, 
                formulés avec des ingrédients naturels et respectueux de l'environnement.
            </p>
            <p>
                Notre mission est de vous offrir une expérience shopping luxueuse avec des produits de qualité exceptionnelle, 
                tout en respectant la nature et votre peau.
            </p>
        </div>
        <div class="about-image">
            <img src="{{ asset('images/about-beach.png') }}" alt="Reflets dorés sur l'eau — bien-être et nature">
        </div>
    </div>
</section>

@endsection
