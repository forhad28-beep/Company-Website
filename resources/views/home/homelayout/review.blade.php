  <div class="lonyo-section-padding position-relative overflow-hidden">
      <div class="container">
          @php
              $title = App\Models\Title::find(1);
          @endphp
          <div class="lonyo-section-title">
              <div class="row">

                  <div class="col-xl-8 col-lg-8">
                      <h2 id="review-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                          data-id="{{ $title->id }}">
                          {{ $title->reviews }}
                      </h2>
                  </div>

                  <div class="col-xl-4 col-lg-4 d-flex align-items-center justify-content-end">
                      <div class="lonyo-title-btn">
                          <a class="lonyo-default-btn t-btn" href="contact-us.html">Read Customer Stories</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="lonyo-testimonial-slider-init">

          @php
              $review = App\Models\Review::latest()->get();
          @endphp

          @foreach ($review as $item)
              <div class="lonyo-t-wrap wrap2 light-bg">
                  <div class="lonyo-t-ratting">
                      <img src="{{ asset('frontend/assets/images/shape/star.svg') }}" alt="">
                  </div>
                  <div class="lonyo-t-text">
                      <p>{{ $item->message }}</p>
                  </div>
                  <div class="lonyo-t-author">
                      <div class="lonyo-t-author-thumb">
                          <img src="{{ asset($item->image) }}" alt="">
                      </div>
                      <div class="lonyo-t-author-data">
                          <p>{{ $item->name }}</p>
                          <span>{{ $item->position }}</span>
                      </div>
                  </div>
              </div>
          @endforeach


      </div>
      <div class="lonyo-t-overlay2">
          <img src="{{ asset('frontend/assets/images/v2/overlay.png') }}" alt="">
      </div>
  </div>

  
{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const titleElement = document.getElementById('review-title');

        function saveChanges(element) {

            let reviewId = element.dataset.id;
            let field = 'reviews';
            let newValue = element.innerText.trim();

            fetch(`/edit-reviews/${reviewId}`, {
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