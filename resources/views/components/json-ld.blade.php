<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "{{ general_settings('site_name') }}",
            "url": "{{ url('/') }}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{ url('/search?q={search_term_string}') }}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>

<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "{{ general_settings('site_name') }}",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('storage/' . general_settings('site_logo')) }}",
            "sameAs": [
                "{{ general_settings('facebook') }}",
                "{{ general_settings('snapchat') }}",
                "{{ general_settings('twitter') }}",
                "{{ general_settings('instagram') }}",
                "{{ general_settings('linkedin') }}",
                "{{ general_settings('youtube') }}",
                "{{ general_settings('whatsapp') }}"
            ]
        }
    </script>
