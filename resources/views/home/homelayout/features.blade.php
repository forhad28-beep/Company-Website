  <div class="lonyo-content-shape1">
      <img src="{{ asset('frontend/assets/images/shape/shape1.svg') }}" alt="">
  </div>
  <div class="lonyo-section-padding2 position-relative">
      <div class="container">
          @php
              $title = App\Models\Title::find(1);
          @endphp
          <div class="lonyo-section-title center">
              <h2 id="features-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                  data-id="{{ $title->id }}">
                  {{ $title->features }}
              </h2>
          </div>
          <div class="row">
            @php
                $features = App\Models\Feature::latest()->limit(6)->get();
            @endphp
            @foreach ($features as $item)
                              <div class="col-xl-4 col-lg-6 col-md-6">
                  <div class="lonyo-service-wrap light-bg" data-aos="fade-up" data-aos-duration="500">
                      <div class="lonyo-service-title">
                          <h4>{{ $item->title }}</h4>
                          <img src="{{ asset('frontend/assets/images/v1/' . $item->icon . '.svg') }}" alt="">
                      </div>
                      <div class="lonyo-service-data">
                          <p>{{ $item->description }}</p>
                      </div>
                  </div>
              </div>
            @endforeach

          </div>
      </div>
      <div class="lonyo-feature-shape"></div>
  </div>


{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const titleElement = document.getElementById('features-title');

        function saveChanges(element) {

            let featuresId = element.dataset.id;
            let field = 'features';
            let newValue = element.innerText.trim();

            fetch(`/edit-features/${featuresId}`, {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                    body: JSON.stringify({
                        [field]: newValue
                    })
                })

                .then(response => response.json())

                .then(data => {
                    if (data.success) {
                        console.log(`${field} Updated Successfully`);
                    }
                })

                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Save on Enter
        document.addEventListener('keydown', function(e) {

            if (e.key === "Enter" && e.target.id === 'features-title') {

                e.preventDefault();

                saveChanges(e.target);

                e.target.blur();
            }
        });

        // Save on blur
        titleElement.addEventListener('blur', function() {
            saveChanges(titleElement);
        });

    });
</script>
