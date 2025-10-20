/**
 * Performance Optimization Script
 * Reduces main thread work by deferring non-critical operations
 */

// Use Intersection Observer for lazy loading
const lazyLoadElements = () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                // Load content when visible
                if (el.dataset.src) {
                    el.src = el.dataset.src;
                    delete el.dataset.src;
                }
                observer.unobserve(el);
            }
        });
    });

    // Observe all lazy elements
    document.querySelectorAll('[data-lazy]').forEach(el => {
        observer.observe(el);
    });
};

// Defer heavy computations
const deferredInit = () => {
    // Use requestIdleCallback for non-critical work
    if ('requestIdleCallback' in window) {
        requestIdleCallback(() => {
            initializeNonCriticalFeatures();
        }, { timeout: 2000 });
    } else {
        setTimeout(initializeNonCriticalFeatures, 1);
    }
};

// Initialize non-critical features
const initializeNonCriticalFeatures = () => {
    // Calendar interactions
    const calendarCells = document.querySelectorAll('.calendar-table td');
    if (calendarCells.length > 0) {
        // Use event delegation instead of individual listeners
        const calendarTable = document.querySelector('.calendar-table');
        if (calendarTable) {
            calendarTable.addEventListener('click', handleCalendarClick, { passive: true });
        }
    }

    // Lazy load images
    lazyLoadElements();
};

// Handle calendar clicks with event delegation
const handleCalendarClick = (e) => {
    const cell = e.target.closest('td');
    if (cell && !cell.classList.contains('empty')) {
        // Handle click
        console.log('Calendar cell clicked');
    }
};

// Optimize scroll performance
let ticking = false;
const optimizeScroll = () => {
    if (!ticking) {
        requestAnimationFrame(() => {
            // Handle scroll
            ticking = false;
        });
        ticking = true;
    }
};

// Use passive event listeners
document.addEventListener('scroll', optimizeScroll, { passive: true });

// Start deferred initialization
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', deferredInit);
} else {
    deferredInit();
}

// Export for use in other scripts
window.performanceOptimization = {
    lazyLoadElements,
    deferredInit
};