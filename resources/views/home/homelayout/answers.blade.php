  <div class="lonyo-section-padding4">
    <div class="container">
      <div class="lonyo-section-title center">
                  @php
              $title = App\Models\Title::find(1);
          @endphp
               <h2 id="answer-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
        data-id="{{ $title->id }}">
                          {{ $title->answers }}
                      </h2>
      </div>
      <div class="lonyo-faq-shape"></div>
      <div class="lonyo-faq-wrap1">
        @php
          $faqs = App\Models\Faq::latest()->get();
        @endphp

        @foreach ($faqs as $faq)
          <div class="lonyo-faq-item item2 open" data-aos="fade-up" data-aos-duration="500">
          <div class="lonyo-faq-header">
            <h4>{{ $faq->question }}</h4>
            <div class="lonyo-active-icon">
              <img class="plasicon" src="{{ asset('frontend/assets/images/v1/mynus.svg') }}" alt="">
              <img class="mynusicon" src="{{ asset('frontend/assets/images/v1/plas.svg') }}" alt="">
            </div>
          </div>
          <div class="lonyo-faq-body body2">
            <p>{{ $faq->answer }}</p>
          </div>
        </div>
        @endforeach


      </div>
      <div class="faq-btn" data-aos="fade-up" data-aos-duration="700">
        <a class="lonyo-default-btn faq-btn2" href="faq.html">Can't find your answer</a>
      </div>
    </div>
  </div>


  {{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const titleElement = document.getElementById('answer-title');

        function saveChanges(element) {

            let answerId = element.dataset.id;
            let field = 'answers';
            let newValue = element.innerText.trim();

            fetch(`/edit-answers/${answerId}`, {
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

            if (e.key === "Enter" && e.target.id === 'answer-title') {

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