// HAMBURGER MENU
const menuOverlay = document.querySelector('.menu-overlay')
const menu = document.querySelector('.menu')
const hamShowBtn = document.querySelector('.fa-bars.hamburger')
const hamCloseBtn = document.querySelector('.fa-xmark.hamburger')
hamShowBtn.addEventListener('click', () => {
    hamShowBtn.classList.add('hide')
    menuOverlay.classList.add('active')
    menu.classList.add('active')
    hamCloseBtn.classList.add('active')
    close(menuOverlay,menu,'',hamCloseBtn,hamShowBtn)

})
// SCROLL TO SECTION
const menuLinks = document.querySelectorAll('.menu-link')
menuLinks.forEach( (link) => {
    link.addEventListener('click', () => {
        const sectionClass = link.dataset.key
        const section = document.querySelector(`.${sectionClass}`)
        section.scrollIntoView({behavior: "smooth"})
        if (menuOverlay) {
            menuOverlay.classList.remove('active')
            menu.classList.remove('active')
            hamCloseBtn.classList.remove('active')
            hamShowBtn.classList.remove('hide')
        }
    })
})
// HOVER MENU AFTER SCROLL
const sections = document.querySelectorAll('section')
document.addEventListener('scroll', () => {
    sections.forEach(section => {
        let top = window.scrollY
        let offset = section.offsetTop-100
        let height = section.offsetHeight
        const sectionClass = section.classList.value
        if (top >= offset && top < offset + height) {
            menuLinks.forEach(link => {
                link.classList.remove('active')
                document.querySelector(`li[data-key=${sectionClass}]`).classList.add('active')
            })
        }
    })
})
// HERO SLIDER
let slideIndex = 0
slider()
function slider() {
    const slides = document.getElementsByClassName('slide')
    const dots = document.getElementsByClassName('dot')
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active')
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active')
    }
    slideIndex++
    if (slideIndex > slides.length) {slideIndex = 1}
    slides[slideIndex-1].classList.add('active')
    dots[slideIndex-1].classList.add('active')
    setTimeout(slider, 2000);
}
// PROJECT MODAL: show/close
const projects = document.querySelectorAll('.single-project')
const overlay = document.querySelector('.modal-overlay')
projects.forEach((project) => {
    project.addEventListener('click', () => {
        createModal(project, overlay)
        const closeBtn = document.querySelector('.fa-xmark.modal')
        const modal = document.querySelector('.project-modal')
        close(overlay,'',modal,closeBtn,'',)
    })
})
// PROJECT MODAL: create
const createModal = (project, overlay) => { 
    const projectId = project.dataset.project
    const image = project.querySelector('img').src
    const title = project.querySelector('#title').innerHTML
    const descr = project.querySelector('#descr').innerHTML
    const techs = project.querySelectorAll('.techs')
    const modal = document.createElement('div')
    modal.classList.add('project-modal')
    modal.innerHTML =`
    <img src="${image}" alt="project details">
    <div class="project-info">
        <i class="fa-solid fa-xmark modal"></i>
        <h3>${title}</h3>
        <p>${descr}</p>
        <h3>Technologies</h3>
        <div class="techs">
        ${techs[0].innerHTML}
        </div>
        <div class="links">
            <a class="demo" href="${setDemoSrc(projectId)}" target="_blank">Live demo</a>
            <a class="github" href="https://github.com/PyCoderPL" target="_blank"><i class="fa-brands fa-github fa-2x"></i></a>
        </div>
    </div>`
    overlay.appendChild(modal)
    overlay.classList.add('active')
}
//PROJECT MODAL: set demo href
let setDemoSrc = (projectId) => {
    if (projectId === '1') {
        return 'http://simplestore.server054599.nazwa.pl'             
    } else if (projectId === '2') {
        return 'http://todoapp.server054599.nazwa.pl/public/index.php/lists'
    } else if (projectId === '3') {
        return 'http://adrespect.server054599.nazwa.pl'
    }
}
// CLOSE: modal/menu
const close = (overlay, menu, modal, closeBtn, showBtn) => {
    closeBtn.addEventListener('click', () => {
        overlay.classList.remove('active')
        overlay.innerHTML =''
        if (menu) {
            menu.classList.remove('active')
            closeBtn.classList.remove('active')
            showBtn.classList.remove('hide')
        }
    })
    overlay.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-overlay') || e.target.classList.contains('menu-overlay')) {
            overlay.classList.remove('active')
            overlay.innerHTML = ''
            if (menu) {
                menu.classList.remove('active')
                closeBtn.classList.remove('active')
                showBtn.classList.remove('hide')                
            }
        }
    })
    if (modal) {
        modal.focus()
        modal.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                overlay.classList.remove('active')
                overlay.innerHTML = ''
            }
        })
    }
}