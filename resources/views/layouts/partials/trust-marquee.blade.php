@php
    $trustItems = [
        ['icon' => '🚚', 'title' => 'Livraison gratuite', 'sub' => 'Sur les commandes éligibles'],
        ['icon' => '↩', 'title' => 'Retours 30 jours', 'sub' => 'Satisfait ou remboursé'],
        ['icon' => '🔒', 'title' => 'Paiement sécurisé', 'sub' => 'Transactions protégées'],
    ];
@endphp
<style>
    .pb-trust {
        background: #4a5d4a;
        color: #fff;
        overflow: hidden;
    }
    .pb-trust__marquee {
        overflow: hidden;
        padding: 1.1rem 0;
    }
    .pb-trust__track {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        width: max-content;
        gap: 3.5rem;
        padding: 0 1.5rem;
        animation: pbTrustScroll 22s linear infinite;
        will-change: transform;
    }
    .pb-trust__marquee:hover .pb-trust__track {
        animation-play-state: paused;
    }
    @keyframes pbTrustScroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
    .pb-trust__item {
        display: flex;
        flex-direction: row;
        flex-shrink: 0;
        align-items: center;
        gap: 0.85rem;
        white-space: nowrap;
    }
    .pb-trust__icon {
        font-size: 1.35rem;
        line-height: 1;
    }
    .pb-trust__text strong {
        display: block;
        font-size: 0.88rem;
        font-weight: 500;
        margin-bottom: 0.1rem;
    }
    .pb-trust__text span {
        display: block;
        font-size: 0.78rem;
        opacity: 0.88;
    }
</style>
<section class="pb-trust" aria-label="Nos garanties">
    <div class="pb-trust__marquee">
        <div class="pb-trust__track">
            @foreach (range(1, 2) as $copy)
                @foreach ($trustItems as $item)
                    <div class="pb-trust__item">
                        <span class="pb-trust__icon" aria-hidden="true">{{ $item['icon'] }}</span>
                        <div class="pb-trust__text">
                            <strong>{{ $item['title'] }}</strong>
                            <span>{{ $item['sub'] }}</span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
