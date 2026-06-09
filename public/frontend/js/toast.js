/* ════════════════════════════════
   TOAST NOTIFICATIONS
   ════════════════════════════════ */
class ToastNotify {
    constructor() {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
    }

    show(message, type = 'success', duration = 4000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${this.icon(type)}"></i>
            <span>${message}</span>
        `;
        
        this.container.appendChild(toast);
        
        // Animate in
        requestAnimationFrame(() => toast.classList.add('show'));
        
        // Remove after duration
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    icon(type) {
        const icons = { success: 'check-circle', error: 'times-circle', warning: 'exclamation-triangle', info: 'info-circle' };
        return icons[type] || 'info-circle';
    }
}

const toast = new ToastNotify();

/* ════════════════════════════════
   SCROLL PROGRESS BAR
   ════════════════════════════════ */
const scrollProgress = document.createElement('div');
scrollProgress.className = 'scroll-progress';
document.body.appendChild(scrollProgress);

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = (scrollTop / docHeight) * 100;
    scrollProgress.style.width = progress + '%';
});

/* ════════════════════════════════
   CURSOR GLOW EFFECT
   ════════════════════════════════ */
const cursorGlow = document.createElement('div');
cursorGlow.className = 'cursor-glow';
document.body.appendChild(cursorGlow);

document.addEventListener('mousemove', (e) => {
    cursorGlow.style.left = e.clientX + 'px';
    cursorGlow.style.top = e.clientY + 'px';
});