<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Calendrier des événements ASIMM">
  <title>Calendrier - ASIMM</title>

  <link rel="icon" href="{{ asset('assets/img/tabimg.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">

  <script type="application/ld+json">
  {"@@context":"https://schema.org","@type":"Organization","name":"ASIMM","url":"https://www.asimm.org","logo":"https://www.asimm.org/assets/img/tabimg.png"}
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="calendrier-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logoasimm.webp') }}" alt="ASIMM">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/') }}">Accueil</a></li>

          <li class="dropdown">
            <a href="{{ url('/') }}"><span>L’ASIMM</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ url('/#about') }}">Mission &amp; vision</a></li>
              <li><a href="{{ url('/#how-we-work') }}">Comment participer</a></li>
              <li><a href="{{ url('/#team') }}">Conseil d’administration</a></li>
              <li><a href="{{ url('/#faq') }}">FAQ</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="{{ route('events.calendar') }}" class="active"><span>Activités</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ route('events.calendar') }}">Calendrier des événements</a></li>
              <li><a href="{{ url('/#services') }}">Ateliers &amp; conférences</a></li>
            </ul>
          </li>

          <li><a href="{{ url('/#contact') }}">Contact</a></li>
          <li><a href="{{ url('/membership.html') }}">Rejoignez-nous</a></li>
        </ul>

        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Calendrier</h1>
      </div>
    </div>

    <section id="events-2" class="events-2 section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="events-list">
              @if ($jourChoisi)
                <h4 class="events-section-label">
                  Événements du {{ $jourChoisi->locale('fr')->isoFormat('D MMMM YYYY') }}
                  — <a href="{{ route('events.calendar') }}">Tous les événements</a>
                </h4>
                @if ($evenements->isEmpty())
                  <p>Aucun événement ce jour-là.</p>
                @endif
              @endif

              @foreach ($evenements as $evenement)
                <div class="event-item" id="evenement-{{ $evenement->id }}">
                  <div class="event-date">
                    <span class="day">{{ $evenement->start_date->format('d') }}</span>
                    <span class="month">{{ rtrim($evenement->start_date->locale('fr')->isoFormat('MMM'), '.') }}</span>
                  </div>
                  <div class="event-content">
                    <h3>{{ $evenement->title }}</h3>
                    <div class="event-meta">
                      <p>
                        <svg class="event-icon" viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="6.75"></circle><path d="M8 4v4l2.5 1.5"></path></svg>
                        {{ $evenement->start_date->locale('fr')->isoFormat('D MMMM YYYY') }} {{ $evenement->schedule }}
                      </p>
                      <p>
                        <svg class="event-icon" viewBox="0 0 16 16" aria-hidden="true"><path d="M13 6.5c0 4-5 8-5 8s-5-4-5-8a5 5 0 1 1 10 0Z"></path><circle cx="8" cy="6.5" r="1.75"></circle></svg>
                        {{ $evenement->location }}
                      </p>
                    </div>
                    <p>{{ $evenement->description }}</p>
                    @if ($evenement->link_url)
                      <a href="{{ $evenement->link_url }}" class="btn-event" target="_blank" rel="noopener">{{ $evenement->link_label ?: 'Détails' }}
                        <svg class="event-icon event-icon-arrow" viewBox="0 0 16 16" aria-hidden="true"><path d="M2 8h11M8 3l5 5-5 5"></path></svg>
                      </a>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sidebar">
              <div class="sidebar-item" data-aos="fade-up" data-aos-delay="100">
                <h3 class="sidebar-title">Prochaines activités</h3>

                <div class="event-calendar">
                  <div class="calendar-header">
                    <h4>{{ ucfirst($calendrier['mois']->locale('fr')->isoFormat('MMMM YYYY')) }}</h4>
                  </div>
                  <div class="calendar-body">
                    <div class="weekdays">
                      <div>Lu</div>
                      <div>Ma</div>
                      <div>Me</div>
                      <div>Je</div>
                      <div>Ve</div>
                      <div>Sa</div>
                      <div>Di</div>
                    </div>

                    <div class="days">
                      @foreach ($calendrier['jours'] as [$date, $evenement])
                        <a href="{{ route('events.calendar', ['jour' => $date->format('Y-m-d')]) }}"
                           class="day {{ $evenement ? 'has-event' : '' }} {{ $date->month == $calendrier['mois']->month ? '' : 'other-month' }} {{ isset($jourChoisi) && $jourChoisi->isSameDay($date) ? 'is-selected' : '' }}"
                           title="{{ $evenement?->title }}">{{ $date->day }}</a>
                      @endforeach
                    </div>
                  </div>
                </div>

                <p class="mt-3 mb-0 small">
                  Consultez nos annonces et nos publications pour connaître les prochains événements, les dates importantes et les modalités d’inscription.
                </p>
              </div>

              <div class="sidebar-item featured-event" data-aos="fade-up" data-aos-delay="200">
                <h3 class="sidebar-title">Évènement à la une</h3>
                <div class="featured-event-content">
                  <img src="{{ asset('assets/img/asimm/seene.webp') }}" alt="SEENE Workshop" class="img-fluid">
                  <h4>SEENE Workshop (2–4 déc.)</h4>
                  <p><i class="bi bi-calendar-event"></i> Atelier international – Montréal</p>
                  <p class="mb-3">
                    Focus 2025 : IA générative et défense nationale. Opportunité de veille, d’échanges et de liens avec l’écosystème.
                  </p>
                  <a href="https://www.linkedin.com/feed/update/urn:li:activity:7400203040621903872/" class="btn-register">Détails</a>
                </div>
              </div>

              <div class="sidebar-item" data-aos="fade-up" data-aos-delay="300">
                <h3 class="sidebar-title">Types d’activités</h3>
                <div class="categories">
                  <ul>
                    <li><a href="{{ route('events.calendar') }}#events-2">Panels &amp; conférences</a></li>
                    <li><a href="{{ route('events.calendar') }}#events-2">Déjeuners-causeries</a></li>
                    <li><a href="{{ route('events.calendar') }}#events-2">Midi-conférences</a></li>
                    <li><a href="{{ route('events.calendar') }}#events-2">Évènements partenaires</a></li>
                  </ul>
                </div>
              </div>

              <div class="sidebar-item" data-aos="fade-up" data-aos-delay="400">
                <h3 class="sidebar-title">Rester informé</h3>
                <p class="mb-3">
                  ASIMM partage ses annonces et opportunités (évènements, panels, collaborations) via ses canaux publics.
                </p>
                <a href="https://ca.linkedin.com/company/asimm" target="_blank" rel="noopener" class="btn-register">Suivre ASIMM / Nous contacter</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <svg class="icon footer-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
          <div class="address">
            <h4>Adresse</h4>
            <p>355 Rue Peel, Suites 203-208</p>
            <p>Montréal, QC, H3C 2G9</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <svg class="icon footer-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg>
          <div>
            <h4>Contact</h4>
            <p>
              <strong>Email :</strong>
              <a href="mailto:info@asimm.org">info@asimm.org</a><br>
              <strong>Partenariats / Conférenciers :</strong>
              <a href="mailto:info@asimm.org">info@asimm.org</a>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <svg class="icon footer-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M7 3v4m10-4v4M3 10h18"></path><path d="M8 14h2m4 0h2m-8 3h2"></path></svg>
          <div>
            <h4>Activités</h4>
            <p>
              <strong>Calendrier :</strong>
              <a href="{{ route('events.calendar') }}">Voir les événements</a><br>
              <strong>Adhésion :</strong>
              <a href="{{ url('/membership.html') }}">Rejoignez-nous</a>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>Nous suivre</h4>
          <div class="social-links d-flex">
            <a href="https://ca.linkedin.com/company/asimm" class="linkedin" target="_blank" rel="noopener" aria-label="LinkedIn ASIMM">
              <svg class="social-icon" viewBox="0 0 16 16" aria-hidden="true"><path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146ZM4.943 13.394V6.169H2.542v7.225h2.401ZM3.743 5.18c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.358.54-1.358 1.248 0 .694.52 1.248 1.327 1.248h.015Zm4.908 8.214V9.359c0-.216.016-.432.08-.586.173-.432.568-.879 1.23-.879.869 0 1.217.663 1.217 1.635v3.865h2.4V9.25c0-2.22-1.185-3.253-2.767-3.253-1.274 0-1.845.7-2.16 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4Z"></path></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Retour en haut">
    <svg class="scroll-top-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5m-6 6 6-6 6 6"></path></svg>
  </a>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
