<!-- Sidebar -->
      <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
            <ul>
              <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                  <a href="{{ route('home') }}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
              </li>
              <li class="{{ Route::currentRouteName() == 'getorganizationhierarchy' ? 'active' : '' }}">
                  <a href="{{ route('getorganizationhierarchy') }}"><i class="la la-tree"></i> <span> Hierarchy</span></a>
              </li>
              <?php if ($collection){ ?>
                  <?php $menuchecker = 0; foreach ($categories as $cat){ 
                    $modules_of_this_category = $module_object->where('status', 1)->where('category_id', $cat->id)->get(); ?>
                      
                      <?php if (!$modules_of_this_category->isEmpty()){
                            foreach($modules_of_this_category as $mod){
                                if(in_array($mod->slug , $collection)){
                                if($menuchecker == 0){ ?>
                                <li class="menu-title">{{$cat->name}}</li>
                                <!-- <li class="submenu">
                                    <a href="javascript:void(0)">
                                        <i class="{{ $cat->icon ? $cat->icon : 'la la-graduation-cap' }}"></i> <span> {{$cat->name}} </span> <span class="menu-arrow"></span>
                                    </a>
                                    <ul style="display: none;"> -->
                                    <?php 
                                        $menuchecker++;
                                  }
                                    ?>
                                    <li class="{{ request()->url() == $mod->menu_template ? 'active' :'inactive' }}"> 
                                      <a  href="{{ $mod->menu_template }}" ><i class="{{ $mod->icon ? $mod->icon : 'la la-graduation-cap' }}"></i> <span>{{ $mod->module_name}}</span></a>
                                    </li>
                                    <!-- <li class="{{ request()->url() == $mod->menu_template ? 'active' :'inactive' }}">
                                        <a href="{{ $mod->menu_template }}" class="{{ request()->url() == $mod->menu_template ? 'active' :'inactive' }}"> <span>{{ $mod->module_name}}</span>
                                        </a>
                                    </li> -->
                                <?php } ?>
                            <?php } ?>    
                            <!-- You don't have permission -->
                        <?php } ?>
                    <?php if($menuchecker == 1){ ?>
                        <!-- </ul>
                    </li> -->
                    <?php  $menuchecker = 0;?>
                  <?php } ?>
                
                  <?php } ?>
                  <?php } ?>
               
            </ul>

          </div>
        </div>
      </div>
<!-- /Sidebar -->









 @if(
    Auth::check() &&
    Auth::user()->change_password == 0 &&
    !request()->routeIs('userchangepassword') &&
    !request()->routeIs('update-password')
)

<!-- Force Password Change Modal -->
{{-- 
    KEY FIX: The modal div is moved to document.body via JavaScript.
    This breaks it out of any parent stacking context (dropdowns, sidebars, etc.)
    that would otherwise render on top of it regardless of z-index.
--}}
<div id="force-password-modal" style="display:none;">

    <!-- Backdrop -->
    <div id="fpm-backdrop"></div>

    <!-- Modal Card -->
    <div id="fpm-card">

        <!-- Top accent bar -->
        <div id="fpm-accent-bar"></div>

        <!-- Icon + Header -->
        <div id="fpm-header">
            <div id="fpm-icon-wrap">
                <svg id="fpm-shield-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <div id="fpm-badge">Action Required</div>
            <h2 id="fpm-title">Your Password Is Weak</h2>
            <p id="fpm-subtitle">
                You must update your password to a stronger one before you can continue using the system. This step is mandatory for your account security.
            </p>
        </div>

        <!-- Divider -->
        <div id="fpm-divider"></div>

        <!-- Requirements -->
        <div id="fpm-requirements">
            <p id="fpm-req-label">New password must meet all of the following:</p>
            <ul id="fpm-req-list">
                <li class="fpm-req-item">
                    <span class="fpm-req-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </span>
                    <span>8 – 12 characters in length</span>
                </li>
                <li class="fpm-req-item">
                    <span class="fpm-req-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </span>
                    <span>At least 1 letter (a–z or A–Z)</span>
                </li>
                <li class="fpm-req-item">
                    <span class="fpm-req-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </span>
                    <span>At least 1 number (0–9)</span>
                </li>
                <li class="fpm-req-item">
                    <span class="fpm-req-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                    </span>
                    <span>At least 1 special character (!@#$%^&amp;*)</span>
                </li>
            </ul>
        </div>

        <!-- CTA Button -->
        <a href="{{ route('userchangepassword') }}" id="fpm-cta">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Change Password Now
        </a>

        <p id="fpm-footer-note">You will not be able to access any part of the system until your password is updated.</p>

    </div>
</div>

<style>
/* ─── Reset & Containment ────────────────────────────────────────────── */
#force-password-modal {
    position: fixed;
    inset: 0;
    z-index: 2147483647; /* Maximum possible z-index */
    display: flex !important;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    /* Isolation creates a new stacking context at the top level */
    isolation: isolate;
}

/* ─── Backdrop ───────────────────────────────────────────────────────── */
#fpm-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(10, 10, 20, 0.88);
    backdrop-filter: blur(12px) saturate(0.6);
    -webkit-backdrop-filter: blur(12px) saturate(0.6);
}

/* ─── Card ───────────────────────────────────────────────────────────── */
#fpm-card {
    position: relative;
    width: 100%;
    max-width: 480px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow:
        0 0 0 1px rgba(0,0,0,0.06),
        0 24px 64px rgba(0,0,0,0.28),
        0 8px 24px rgba(0,0,0,0.14);
    overflow: hidden;
    animation: fpm-rise 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes fpm-rise {
    from { opacity: 0; transform: translateY(24px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
}

/* ─── Accent Bar ─────────────────────────────────────────────────────── */
#fpm-accent-bar {
    height: 5px;
    background: linear-gradient(90deg, #dc2626 0%, #f97316 50%, #dc2626 100%);
    background-size: 200% 100%;
    animation: fpm-bar-slide 3s linear infinite;
}

@keyframes fpm-bar-slide {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ─── Header ─────────────────────────────────────────────────────────── */
#fpm-header {
    padding: 2rem 2rem 1.5rem;
    text-align: center;
}

#fpm-icon-wrap {
    width: 68px;
    height: 68px;
    border-radius: 16px;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 1.5px solid #fecaca;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
}

#fpm-shield-icon {
    width: 32px;
    height: 32px;
    color: #dc2626;
}

#fpm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.3rem 0.75rem;
    border-radius: 100px;
    margin-bottom: 0.9rem;
}

#fpm-title {
    font-size: 1.55rem;
    font-weight: 700;
    color: #111827;
    letter-spacing: -0.02em;
    margin: 0 0 0.75rem;
    line-height: 1.25;
}

#fpm-subtitle {
    font-size: 0.92rem;
    color: #6b7280;
    line-height: 1.65;
    margin: 0;
    max-width: 380px;
    margin-inline: auto;
}

/* ─── Divider ────────────────────────────────────────────────────────── */
#fpm-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 0 2rem;
}

/* ─── Requirements ───────────────────────────────────────────────────── */
#fpm-requirements {
    padding: 1.5rem 2rem;
    background: #fafafa;
}

#fpm-req-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #9ca3af;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin: 0 0 1rem;
}

#fpm-req-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}

.fpm-req-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    font-size: 0.9rem;
    color: #374151;
    font-weight: 500;
}

.fpm-req-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    color: #16a34a;
    display: flex;
    align-items: center;
}

.fpm-req-icon svg {
    width: 20px;
    height: 20px;
}

/* ─── CTA ────────────────────────────────────────────────────────────── */
#fpm-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    margin: 0 2rem 1rem;
    padding: 0.95rem 1.5rem;
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
    color: #fff;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 12px;
    text-decoration: none;
    letter-spacing: 0.01em;
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
    transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
}

#fpm-cta:hover {
    background: linear-gradient(135deg, #1e40af, #1d4ed8);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
    transform: translateY(-1px);
}

#fpm-cta:active {
    transform: translateY(0) scale(0.98);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

/* ─── Footer Note ────────────────────────────────────────────────────── */
#fpm-footer-note {
    text-align: center;
    font-size: 0.78rem;
    color: #9ca3af;
    padding: 0 2rem 1.75rem;
    margin: 0;
    line-height: 1.5;
}
</style>

<script>
(function () {
    // Move the modal to <body> so it escapes ALL parent stacking contexts.
    // This is the definitive fix for z-index wars with dropdowns/sidebars.
    var modal = document.getElementById('force-password-modal');
    if (modal && modal.parentNode !== document.body) {
        document.body.appendChild(modal);
    }

    // Prevent scrolling on the page behind the modal
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
})();
</script>

@endif