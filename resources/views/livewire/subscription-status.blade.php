<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

<div>
    @if($subscriptionPlan == 'Not subscribe')
    <a    href="{{ route('pricing.home') }}" class="py-3.5 px-8 w-full max-w-[422px] animate-border rounded-xl border border-transparent [background:linear-gradient(45deg,#172033,theme(colors.slate.800)_50%,#172033)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.600/.48)_80%,_theme(colors.indigo.500)_86%,_theme(colors.indigo.300)_90%,_theme(colors.indigo.500)_94%,_theme(colors.slate.600/.48))_border-box]">
  <span >Subscribe Now</span>
</a>
    @else
    <a   onclick="triggerConfetti()" class="py-3.5 px-8 w-full max-w-[422px] animate-border rounded-xl border border-transparent [background:linear-gradient(45deg,#172033,theme(colors.slate.800)_50%,#172033)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.600/.48)_80%,_theme(colors.indigo.500)_86%,_theme(colors.indigo.300)_90%,_theme(colors.indigo.500)_94%,_theme(colors.slate.600/.48))_border-box]">
  <span >{{ $subscriptionPlan }} Plan</span>
</a>
   
    @endif
</div>


<script>
        function triggerConfetti() {
            // Trigger confetti
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { x: 0.5, y: 0.5 },
                colors: ['#ff0000', '#00ff00', '#0000ff']
            });
        }
    </script>
