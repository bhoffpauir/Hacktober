    <div class="content-box">
      @if ($summary)
        <details class="article-summary">
          <summary>TL;DR</summary>
          <p>{{ $summary->summary }}</p>
        </details>
        @else
        No summary
        @endif
    </div>
