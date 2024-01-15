function debounce(cb, delay = 250) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            cb(...args);
        }, delay);
    }
}
// All Dropdown footer and single product
// Add class 'dropdown-description' to button.dropdown-header for single product page
function dropdowSingleProduct() {
    let dropdowns = document.querySelectorAll('.dropdown-header');
    if (dropdowns) {
        dropdowns.forEach((item, index) => {

            item.addEventListener('click', function () {
                let height = 0;
                if(this.parentNode.classList.contains('open')) {
                    this.parentNode.classList.remove('open');
                    item.nextElementSibling.classList.remove('open');
                } else {
                    this.parentNode.classList.add('open');
                    for (const child of item.nextElementSibling.children) {
                        height += child.offsetHeight;
                    }
                    item.nextElementSibling.classList.add('open');
                }
                 
                if (item.nextElementSibling.classList.contains('open')) {
                    item.nextElementSibling.style.height = height + "px"; 

                } else {

                    item.nextElementSibling.style.height = 0;
                    if (item.classList.contains('dropdown-description')) {
                        let fullDescrElem = item.nextElementSibling.querySelector('.full-descr-dropdown');

                        if (fullDescrElem.classList.contains('show')) {
                            setTimeout(function () {

                                item.nextElementSibling.querySelector('.trimm-descr-dropdown').classList.remove('show');
                                item.nextElementSibling.querySelector('.full-descr-dropdown').classList.remove('show');
                                document.getElementById('read-more-dropdown').style.display = 'block';

                            }, 400);
                        }
                    }


                }

            }, false);

        });
    }

}
function dropdowSingleProductResize() {
    let dropdowns = document.querySelectorAll('.footer-inner-main .dropdown-content');
    if (dropdowns) {
        if(document.documentElement.clientWidth >= 600) {
            dropdowns.forEach((item, index) => {
                item.style.height = 'auto';
            });

        } else {
            dropdowns.forEach((item, index) => {
                item.style.height = 0;
                item.classList.remove('open');
                item.closest('.dropdown-item').classList.remove('open');
            });

        }
    }
}
function showSeoTextResize() {
    let but = document.getElementById('button-seo-text');
    let textContainer = document.getElementById('seo-text-conteiner');
    if(but) {
        if(but.classList.contains('show')) {
            but.classList.remove('show');
            textContainer.classList.remove('open-seo');
            textContainer.style.height = '70px'; // 70px in figma design
            but.querySelector('span').textContent = 'Show more';
        }
    }
    
}

function buttonsPlusMinusQty() {
    let qtyRow = document.querySelectorAll('.item-quantity-row');
    if (!qtyRow) return false;
    
  
        // let butPlusQty = row.querySelector('.button-action-plus-quantity');
        // let butMinusQty = row.querySelector('.button-action-minus-quantity');

        let val, min, max, step, valInput, qtyField;


        let butAddCart = jQuery(document).find(".summary [name='update_cart']");
        
       
            document.addEventListener('click', function (event) {
               
                const buttonQty = event.target.classList.contains('control-quantity-button') ? event.target : event.target.closest('.control-quantity-button');
                if(buttonQty) {
                    event.preventDefault();
                    if(buttonQty.classList.contains('button-action-plus-quantity')) {
                        qtyField = buttonQty.closest('.item-quantity-row').querySelector('input.qty');
    
                        val = parseInt(qtyField.value);
                        min = parseInt(qtyField.getAttribute('min'));
                        max = parseInt(qtyField.getAttribute('max'));
                        step = parseInt(qtyField.getAttribute('step'));
    
                        if (!valInput || valInput === '' || valInput === 'NaN') valInput = 0;
                        if (max === '' || max === 'NaN') max = '';
                        if (min === '' || min === 'NaN') min = 0;
    
                        valInput = val + step;
                        if (valInput <= max) {
                            qtyField.value = valInput;
                            butAddCart.trigger('click');
                        } 

                        document.dispatchEvent(
                            new CustomEvent("universalChangeQuantity", {
                                bubbles: true,
                                detail: {
                                    input: qtyField,
                                    quantity: parseInt(qtyField.value),
                                    productId: parseInt(qtyField.getAttribute('product-id')),
                                    productVariation: parseInt(qtyField.getAttribute('product-variation')),
                                    actionCart: 'plus'
                                },
                            }),
                        );
                    }
                    if(buttonQty.classList.contains('button-action-minus-quantity')) {
                        event.preventDefault();
    
                        qtyField = buttonQty.closest('.item-quantity-row').querySelector('input.qty');
                        val = parseInt(qtyField.value);
                        min = parseInt(qtyField.getAttribute('min'));
                        max = parseInt(qtyField.getAttribute('max'));
                        step = parseInt(qtyField.getAttribute('step'));
    
                        if (!valInput || valInput === '' || valInput === 'NaN') valInput = 0;
                        if (max === '' || max === 'NaN') max = '';
                        if (min === '' || min === 'NaN') min = 0;
    
                        valInput = val - step;
                        if (valInput >= min) {
                            qtyField.value = valInput;
    
                            butAddCart.trigger('click');
                        }
    
                        document.dispatchEvent(
                            new CustomEvent("universalChangeQuantity", {
                                bubbles: true,
                                detail: {
                                    input: qtyField,
                                    quantity: parseInt(qtyField.value),
                                    productId: parseInt(qtyField.getAttribute('product-id')),
                                    productVariation: parseInt(qtyField.getAttribute('product-variation')),
                                    actionCart: 'minus'
                                },
                            }),
                        );
                    }



                }
               
                

            });
           
      

  
}

document.addEventListener("DOMContentLoaded", function () {

    buttonsPlusMinusQty();

    const inputs = document.querySelectorAll('input:not([type="checkbox"],[type="radio"],[type="hidden"])');
    inputs.forEach(input => {
        if(input.closest('.form-row')) {
            input.closest('.form-row').classList.add('input-element');
        }
        if(input.closest('.input-element')) {
            input.setAttribute('data-label-control', 'true');
            // input.setAttribute('data-required', 'true');

            let inputElement = input.closest('.input-element');
    
            if(input.value != '' && !inputElement.classList.contains('filled')) {
                inputElement.classList.remove('active');
                inputElement.classList.add('filled');
            }

            input.addEventListener('input', () => {
                if(inputElement.classList.contains('filled')) {
                    inputElement.classList.remove('filled');
                }
                if(input.classList.contains('wpcf7-email') && input.classList.contains('wpcf7-not-valid')) {
                    input.classList.remove('wpcf7-not-valid');
                    inputElement.querySelector('.wpcf7-not-valid-tip').remove();
                    input.setAttribute('aria-invalid', false);
                    let form7 = input.closest('form');
                    form7.removeAttribute('data-status');
                    form7.classList.remove('invalid');
                }
                inputElement.classList.add('active');
            });

            input.addEventListener('blur', () => {
                if(input.value != '' && inputElement &&inputElement.classList.contains('active')) {
                    inputElement.classList.remove('active');
                    inputElement.classList.add('filled');
                }
            });
        }
    })

    
    dropdowSingleProduct();
    
    
    class MenuSite {
        constructor(options) {
            this.menu = document.getElementById('menu-main-menu');
            if(!this.menu) return false;
            // this.menuButton = document.getElementById(options.menuButton);
            this.body = document.querySelector('body');
            this.header = document.querySelector('header.header-main');
            this.eventHas = false;
            this.sccClasses = {
                show: 'show-sub-menu',
                fixed: 'fixed'
            };
            this.butCloseInMenu = this.header.querySelector('.close-mobile-menu');
            this.attachEvents();
            this.buttonMobileMenuOpenClose();
            this.windowResizeEvent();
            // this.scrollfixMenu();
            this.toggleHeaderSticky();
        }

        attachEvents() {

            if(document.documentElement.clientWidth <= 1200) {
                let menuLia = this.menu.querySelectorAll('li.menu-item-has-children-attr > a');
                if (menuLia) {
                    menuLia.forEach(el => {
                      
                        el.addEventListener('click', (e) => {
                            e.preventDefault();
                            this.openCloseSearchMenuMobile(el);
                        });
                    
                        
                    });
                }

            } else {

                let menuLi = this.menu.querySelectorAll('li.menu-item-has-children-attr');
                if (menuLi) {
                    menuLi.forEach(el => {
                        
                        el.addEventListener('mouseenter', (e) => {

                            this.openCloseSearchMenuDesktop(el);
                            this.setAttrMenuPosition(el);
                        });
                        el.addEventListener('mouseleave', (e) => {
    
                            this.openCloseSearchMenuDesktop(el);
    
                        });
                        
                    });
                }
            }
            
        }

        openCloseSearchMenuMobile(el) {
 
            if (el.parentElement.classList.contains(this.sccClasses.show)) {

                el.parentElement.classList.remove(this.sccClasses.show);

            } else {
                el.parentElement.classList.add(this.sccClasses.show);

            }
        }
        openCloseSearchMenuDesktop(el) {
 
            if (el.classList.contains(this.sccClasses.show)) {

                el.classList.remove(this.sccClasses.show);

            } else {
                el.classList.add(this.sccClasses.show);

            }
        }
        setAttrMenuPosition(el) {
            let lihover = el.getBoundingClientRect();
            let contentConteiner = el.closest('.content-container').getBoundingClientRect();
            let diff = contentConteiner.left - lihover.left;
            el.querySelector('.wrapper-sub-menu').style.left = diff + 'px';
        }
        mobileMenuOpenClose() {
            if(document.documentElement.clientWidth <= 1200) {
                this.menu.closest('.bottom-bar-header').classList.toggle('mobile-show');
                this.body.classList.toggle('overflow-hidden');
            }
        }
        buttonMobileMenuOpenClose() {
    
            if(document.documentElement.clientWidth <= 1200) {
                const burger = document.getElementById('mobile-button-main-menu');
                const butCloseInMenu = this.header.querySelector('.close-mobile-menu');
                burger.addEventListener('click', () => {
                    burger.classList.toggle('active');
                    this.mobileMenuOpenClose();
                });
                butCloseInMenu.addEventListener('click', () => {
                    burger.classList.toggle('active');
                    this.mobileMenuOpenClose();
                });
                this.eventHas = true;
            } 
            
         
            
            
        }
        windowResizeEvent() {
            window.addEventListener("resize", (e) => {
                console.log(e);
                if(document.documentElement.clientWidth >= 1200) {
                    this.body.classList.remove('overflow-hidden');
                    this.menu.closest('.bottom-bar-header').classList.remove('mobile-show');
                    let menuLi = this.menu.querySelectorAll('.menu-item-has-children-attr');
                    menuLi.forEach(el => {
                        el.classList.remove(this.sccClasses.show);
                    });
                    document.getElementById('mobile-button-main-menu').classList.remove('active');
                }
            
                if(!this.eventHas) {
                    console.log('')
                    this.attachEvents();
                    this.buttonMobileMenuOpenClose();
                }

            });
        }
        
        toggleHeaderSticky() {
            const scrollUp = "sticky";
            const scrollDown = "sticky-up";
            let lastScroll = 0;
            let header = this.header,
                headerHeight = header.offsetHeight,
                bodyOuter = this.body;
                

            window.addEventListener("scroll", function() {
            
              const currentScroll = this.scrollY;
             if (currentScroll <= headerHeight + 50) {
                header.classList.remove(scrollUp);
                header.classList.remove(scrollDown);
                bodyOuter.classList.remove('menu-fix-body','sticky-active');
                return;
              }
        
              if (currentScroll > lastScroll && !header.classList.contains(scrollDown)) {
                // down
                
                // header.querySelector('.menu-item-has-children-attr .show-sub-menu').classList.remove('show-sub-menu');
                bodyOuter.classList.add('menu-fix-body');
                bodyOuter.classList.remove('sticky-active');
                header.classList.remove(scrollUp);
                header.classList.add(scrollDown);
               
                
                
              } else if (currentScroll < lastScroll && header.classList.contains(scrollDown)) {
                // up
                bodyOuter.classList.add('menu-fix-body');
                bodyOuter.classList.add('sticky-active');
                header.classList.remove(scrollDown);
                header.classList.add(scrollUp);
              }
              lastScroll = currentScroll;
               
            });
        }

        scrollfixMenu() {
           
            let el = this.header,
            sH = el.offsetHeight,
            sY = el.getBoundingClientRect().top+sH;
           
            window.addEventListener('scroll', function(){
               console.log(this.scrollY + ' - ' + sY);

                if(this.scrollY >= sY && this.scrollY <= sY+sH) {
                    el.classList.add('fix-menu');
                    el.style.transform = 'translateY(-'+(this.scrollY-sY)/sH*100+'%)';
                    
                } else if(this.scrollY < sY) {
                    el.style.transform = 'translateY(0%)';
                } else if(this.scrollY < this.scrollY <= sY+sH) {
                    el.style.transform = 'translateY(-100%)';
                    
                }
            });
        }
    }

    new MenuSite();

    const swiper = new Swiper('.swiper-slider', {
        slidesPerView: 1,
        loop: true,
        speed: 400,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
    });

    function copyClipBoardSku() {
        let butSku = document.querySelectorAll('.button-copy-sku-product');

        if (butSku) {
            butSku.forEach(but => {
                but.addEventListener('click', (event) => {
                    event.preventDefault();
                    let sku = but.dataset.skuProduct;
                    if (window.isSecureContext && navigator.clipboard) {
                        navigator.clipboard.writeText(sku).then(() => {

                        });
                    }
                    let notifiSku = but.closest('.wrap-top-sku-attr').querySelector('.notification-sku-copied');
                    notifiSku.classList.add('show');
                    setTimeout(() => {
                        notifiSku.classList.remove('show');
                    }, 3000);
                });
            });
           
        }


    }

    copyClipBoardSku();


    function showFullDescrDropdown() {
        let butReadMore = document.getElementById('read-more-dropdown');
        
        if(butReadMore) {
            butReadMore.addEventListener('click', function()  {
                let newHeight;
                
                let styleBut = window.getComputedStyle(butReadMore);

                let butHeight = this.offsetHeight + parseInt(styleBut.marginTop) + parseInt(styleBut.marginBottom); 
                
                this.classList.toggle('open');
                let trimElement = this.closest('.dropdown-content').querySelector('.trimm-descr-dropdown');
             
                trimElement.classList.toggle('show');
                let fullElement = trimElement.previousElementSibling;

                fullElement.classList.toggle('show');
                let attrElement = trimElement.closest('.descr-single-prod-dropdown').nextElementSibling;
                        
                if(this.classList.contains('open')) {
                    butReadMore.querySelector('span').textContent = 'Show less';
                    newHeight = parseInt(this.closest('.dropdown-content').querySelector('.full-descr-dropdown').offsetHeight) 
                        + parseInt(attrElement.offsetHeight)
                        + parseInt(butHeight);
                    
                } else {
                    butReadMore.querySelector('span').textContent = 'Show more';
                    newHeight = parseInt(this.closest('.dropdown-content').querySelector('.trimm-descr-dropdown').offsetHeight) 
                                + parseInt(attrElement.offsetHeight) 
                                + parseInt(butHeight);
                                
                }
                              
                this.closest('.dropdown-content').style.height = newHeight + 'px';
            });
        }

    }

    showFullDescrDropdown();

    function showFullComment() {
        let butShowComment = document.querySelectorAll('.but-read-more-comment');
        if (butShowComment) {
            butShowComment.forEach((item, index) => {
                item.addEventListener('click', function()  {
                    this.classList.toggle('open');
                    // this.style.display = 'none';
                    let trimElement = this.closest('.hide-big-comment-block').querySelector('.trimm-descr-dropdown');
                    let heightTrimElement =  trimElement.offsetHeight;
                    trimElement.classList.toggle('show');
                    let fullElement = trimElement.previousElementSibling;
                    if(this.classList.contains('open')) {
                        this.querySelector('span').textContent = 'Read less';
                    } else {
                        this.querySelector('span').textContent = 'Show more';
                    }
                    fullElement.classList.toggle('show');
                    let contentHeight = trimElement.closest('.dropdown-content').offsetHeight;
                    let newHeight = +trimElement.previousElementSibling.offsetHeight + contentHeight - heightTrimElement;
                    trimElement.closest('.dropdown-content').style.height = newHeight + 'px';
                });
            });

        }

    }

    showFullComment();
          
    function loadmoreReviews() {
        let buttonReviews = document.querySelector('.load-more-reviews');
        if (buttonReviews) {
            buttonReviews.addEventListener('click', function (e) {
                let buttLoadReview = this;
                let currentPage = this.dataset.currentPage;
                let loadPage;
                if (currentPage != 1) {
                    loadPage = parseInt(currentPage) - 1;
                }

                let request = new XMLHttpRequest();
                request.open('POST', '/wp-admin/admin-ajax.php', true);
                request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8' );
                request.onload = function() {
     
                    let result = this.response;
         
                    if(result) {
                        // document.getElementById('conteiner-comment-n').insertAdjacentHTML('beforeEnd',result);
                        let olListComments = document.querySelector('ol.commentlist');
                        olListComments.insertAdjacentHTML('beforeEnd', result);
                        olListComments.closest('.dropdown-content').style.height = 'auto';
                        showFullComment();
                    }

                }
                request.send('action=loadmore_comments&pagenum=' + loadPage + '&prodId=' + buttLoadReview.dataset.prodId);
                buttLoadReview.dataset.currentPage = loadPage;
                if(loadPage == 1) {
                    buttLoadReview.style.display = 'none';
                }

            });
        }

    }

    loadmoreReviews();

  

    //Copy clipboard link in share modal
    function copyClipboardLink() {
        let linkBut = document.getElementById('button-clipboard-copy-link');
        if(linkBut) {
            linkBut.addEventListener('click', function(event){
                event.preventDefault();
                let link = this.dataset.linkProduct;

                if (window.isSecureContext && navigator.clipboard) {
                    navigator.clipboard.writeText(link).then(() => {
                        
                    });
                }
                let notifyLink = document.getElementById('notification-link-copied');
                notifyLink.classList.add('show');
                setTimeout(() => {
                    notifyLink.classList.remove('show');
                }, 3000);
               
            });
        }
    }
    copyClipboardLink();


    function sendEmailToFriend() {
        let but_send = document.getElementById('but-send-mail-friend');
        if(but_send) {
           
            let inpEmail = document.getElementById('email-modal-sharing');
            let inpFriendEmail = document.getElementById('email-friends-modal-sharing');
            let message = document.getElementById('comments-modal-sharing');
           
           
            but_send.addEventListener('click', function(e){
                e.preventDefault();

                let em1 = false;
                let em2 = false;

                let prodId = document.getElementById('ufws-but-product-share').dataset.product;
                let inpEmail = document.getElementById('email-modal-sharing');
                let email = inpEmail.value;
                let inpFriendEmail = document.getElementById('email-friends-modal-sharing');
                let friendEmail = inpFriendEmail.value;
                let message = document.getElementById('comments-modal-sharing');
                let messageText = message.value;
                // let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
                const emailPattern = /^[a-z0-9_\.\-]+@([a-z0-9\-]+\.)+[a-z]{2,6}$/i;

                if(emailPattern.test(email)) {
                    inpEmail.parentElement.classList.remove('error');
                    em1 = true;
                } else {
                    inpEmail.parentElement.classList.add('error');
                }
                if(emailPattern.test(friendEmail)) {

                    inpFriendEmail.parentElement.classList.remove('error');
                    em2 = true;

                } else {
                    inpFriendEmail.parentElement.classList.add('error');
                }
   
                if(em1 && em2) {
                    let link = window.location.href;
                    let imgLink = document.querySelector('.woocommerce-product-gallery__image').dataset.thumb;
                    let titleProd = document.querySelector('h1.product_title').textContent;
                    let descrProdContainer = document.querySelector('.descr-single-prod-dropdown .trimm-descr-dropdown');
                    let descrProd = '';
                    if(descrProdContainer !== null ) {
                        descrProd = descrProdContainer.textContent;
                    } 
                    
                    let request = new XMLHttpRequest();
                    request.open('POST', '/wp-admin/admin-ajax.php', true);
                    request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8' );
                    request.onload = function() {
        
                        let result = this.response;
                    
                        if(result) {
                            inpEmail.parentElement.classList.remove('active');
                            inpEmail.value = '';
                            inpFriendEmail.parentElement.classList.remove('active');
                            inpFriendEmail.value = '';
                            message.parentElement.classList.remove('active');
                            message.value = ''; 
                            let notify = document.getElementById('notification-email-send');
                            if(notify) {
                                notify.classList.add('active');
                                setTimeout(function(){
                                    notify.classList.remove('active')
                                }, 3000);
                            }
                        }
                        
                    }
                    request.send('action=mail_to_friend&email=' + email + '&link=' + link + '&imgLink=' + imgLink + '&titleProd=' + titleProd + '&emailFriend=' + friendEmail + '&message=' + messageText + '&description=' + descrProd + '&prodId=' + prodId);
                }
            });
            inpEmail.addEventListener('focus', (e) => {
                removeError();
            });
            inpFriendEmail.addEventListener('focus', (e) => {
                removeError();
            });

           const removeError = (() => {
                inpEmail.parentElement.classList.remove('error');
                
                inpFriendEmail.parentElement.classList.remove('error');
            
           });
            document.querySelector('.popup-sharing-link .button-close').addEventListener('click', () => {
                removeError();
                inpEmail.value = '';
                inpFriendEmail.value = '';
                message.parentElement.classList.remove('error');
                message.value = ''; 
            })
        }
    }
    sendEmailToFriend();

    function controlLabelInput() {
        let inpControl = document.querySelectorAll('[data-label-control]');
        let inputWrapper;

        inpControl.forEach((inp) => {
            inp.addEventListener('focus', (elem) => {
                if(inp === document.activeElement) {
                    inputWrapper = elem.target.closest('.input-element').classList.add('active');
                }
                document.querySelectorAll('[data-label-control]').forEach((inpn) =>{
                    if(inpn !== document.activeElement && !inpn.value) {
                        inputWrapper = inpn.closest('.input-element').classList.remove('active');
                    }
                });
            });
            
            inp.addEventListener('keyup', function(elem){
                inputWrapper = inp.closest('.input-element');
                if(inp.value){
                    inputWrapper.classList.add('active');
                } else  {
                    inputWrapper.classList.remove('active');
                }
            });
        });

    }
    controlLabelInput();

    function togglePasswordVisibility() {
        let passInputs = document.querySelectorAll('.password');

        if(passInputs) {
            passInputs.forEach(passInput => {
                passInput.closest('.input-element').insertAdjacentHTML('beforeend', `
                    <span class="pass-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="pass-icon--hide" width="24" height="25" viewBox="0 0 24 25" fill="none">
                        <g clip-path="url(#clip0_1713_1368)">
                            <path d="M9.9 4.92418C10.5883 4.76306 11.2931 4.68251 12 4.68418C19 4.68418 23 12.6842 23 12.6842C22.393 13.8198 21.6691 14.8889 20.84 15.8742M14.12 14.8042C13.8454 15.0989 13.5141 15.3353 13.1462 15.4993C12.7782 15.6633 12.3809 15.7514 11.9781 15.7585C11.5753 15.7656 11.1752 15.6916 10.8016 15.5407C10.4281 15.3898 10.0887 15.1652 9.80385 14.8803C9.51897 14.5955 9.29439 14.2561 9.14351 13.8826C8.99262 13.509 8.91853 13.1089 8.92563 12.7061C8.93274 12.3033 9.02091 11.906 9.18488 11.538C9.34884 11.17 9.58525 10.8388 9.88 10.5642M17.94 18.6242C16.2306 19.9272 14.1491 20.649 12 20.6842C5 20.6842 1 12.6842 1 12.6842C2.24389 10.3661 3.96914 8.34078 6.06 6.74418L17.94 18.6242Z" stroke="black" stroke-width="2" stroke-linecap="square"/>
                            <path d="M1.65594 2.34013L22.344 23.0282" stroke="black" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1713_1368">
                            <rect width="24" height="24" fill="white" transform="translate(0 0.684174)"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="pass-icon--show" fill="none">
                        <g clip-path="url(#clip0_1713_2518)">
                            <path d="M12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.7689 12.0001C19.8968 17.0259 16.3076 19.5383 12 19.5383C7.69251 19.5383 4.10325 17.0259 1.2312 12.0001C4.10325 6.97426 7.69251 4.46188 12 4.46188C16.3076 4.46188 19.8968 6.97426 22.7689 12.0001Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1713_2518">
                            <rect width="24" height="24" fill="white"/>
                            </clipPath>
                        </defs>
                        </svg>
                    </span>
                `);
                const toggleElement = passInput.closest('.input-element').querySelector('.pass-toggle');
                if (toggleElement) {
                    toggleElement.addEventListener('click', event => {
                        if (!toggleElement.classList.contains('on')) {
                            toggleElement.classList.add('on');
                            passInput.setAttribute('type', 'text');
                        } else {
                            toggleElement.classList.remove('on');
                            passInput.setAttribute('type', 'password');
                        }
                    });
                }
            });

        }
            
    }
    togglePasswordVisibility();

    function checkPasswordStrength() {
        const inputObs = document.querySelectorAll(".pass-wrapper input");

        if(inputObs) {
            inputObs.forEach(inp => {
                inp.addEventListener('input', elem => {
                    const allIndicators = document.querySelectorAll('.pass-strenght div');
                    const allMsgs = document.querySelectorAll('.pass-tooltip li');

                    let password = inp.value;
                    let validItemsCount = 0;

                    allIndicators.forEach(function(ind) {
                        if (ind.classList.contains('valid')) {
                            ind.classList.remove('valid');
                        }
                    });
                    allMsgs.forEach(function(msg) {
                        if (msg.classList.contains('passed')) {
                            msg.classList.remove('passed');
                        }
                    });
                    
                    // Check for lowercase character
                    let lowercase = /[a-z]/.test(password);
                    if (lowercase) {
                        document.querySelector('.lowercase').classList.toggle('passed', lowercase);
                        validItemsCount++;
                    }
        
                    // Check for uppercase character
                    let uppercase = /[A-Z]/.test(password);
                    if (uppercase) {
                        document.querySelector('.uppercase').classList.toggle('passed', uppercase);
                        validItemsCount++;
                    }
        
                    // Check for number
                    let number = /[0-9]/.test(password);
                    if (number) {
                        document.querySelector('.number').classList.toggle('passed', number);
                        validItemsCount++;
                    }
        
                    // Check for special character
                    let special = /[!?"$%^&)]/.test(password);
                    if (special) {
                        document.querySelector('.special').classList.toggle('passed', special);
                        validItemsCount++;
                    }
        
                    // Check for length
                    let length = password.length >= 12;
                    if (length) {
                        document.querySelector('.length').classList.toggle('passed', length);
                        validItemsCount++;
                    }

                    if(validItemsCount > 0) {
                        const parentElement = document.querySelector('.pass-strenght');
                        
                        let childElements = Array.from(allIndicators).slice(0, validItemsCount);
                        
                        childElements.forEach(function(child) {
                            child.classList.add('valid');
                        });
                    }
                });
            })
        }
    }
    checkPasswordStrength();

    function changeDisplayReviews() {
        let reviews = document.getElementById('inner-review-conteiner');
        if(reviews) {
            const config = {
                attributes: true,
                childList: true,
                subtree: true,
            };
            const callback = function (mutationsList, observer) {
                reviews.querySelector('.ti-widget-container').classList.replace('ti-col-4','ti-col-3');
            };
            const observer = new MutationObserver(callback);
            observer.observe(reviews, config);
        }
    }
    changeDisplayReviews();
    
    function showSeoText() {
        let but = document.getElementById('button-seo-text');
       
        if(but) {

            let textContainer = document.getElementById('seo-text-conteiner');
            let allElem_start = textContainer.querySelectorAll('* :not(strong)');
            let blockHeight_start = 0;
            allElem_start.forEach(el => {
    
                if(!el.classList.contains('blur-block')) {
                    let styleElem = el.currentStyle  || window.getComputedStyle(el);
                    blockHeight_start += parseInt(el.offsetHeight) + parseInt(styleElem.marginBottom);
                }
                
            });

            if(blockHeight_start < textContainer.offsetHeight) {
                
                but.style.display="none";
                textContainer.querySelector('.blur-block').style.display="none";

            } else {
                if(but) {
                    but.addEventListener('click', event => {
                        if(!but.classList.contains('show')) {
                            but.classList.add('show');
                            but.querySelector('span').textContent = 'Show less';
                            textContainer.classList.add('open-seo');
                            let allElem = textContainer.querySelectorAll('* :not(strong)');
                        
                            let blockHeight = 0;
                            allElem.forEach(el => {
                                let styleElem = el.currentStyle  || window.getComputedStyle(el);
                                blockHeight += parseInt(el.offsetHeight) + parseInt(styleElem.marginBottom);
                            });
                            textContainer.style.height = blockHeight + 'px';
                        } else {
                            but.classList.remove('show');
                            textContainer.classList.remove('open-seo');
                            textContainer.style.height = '70px'; // 44px in figma design
                            but.querySelector('span').textContent = 'Show more';
                        }
                        
                    });
                    
                }
            }
        }
    }
    showSeoText();
    
    function searchHeaderForm() {
        let inputSearch = document.getElementById('header-search-input');
        let containerResult = document.getElementById('result-search-container');
        let form = document.getElementById('header-form-search');
        let buttonViewAllresults = containerResult.querySelector('.but-more-search-results');
        let butClearSearchResult = form.querySelector('.clear-search-input');

       

        function readInput(e) {

            let value = inputSearch.value;
            if(value) {
                containerResult.classList.add('show');
                sendRequest(value, containerResult);
                butClearSearchResult.classList.add('show-but');
            }
            
            if(value.length == 0) {
                clearCloseSearchResult();
            }
        }

        inputSearch.addEventListener('input', debounce(() => {
            readInput();
        
        }, 350));
          
        buttonViewAllresults.addEventListener('click', () => {
            if(buttonViewAllresults.classList.contains('no-results')) {
                window.location.href = window.location.origin + '/shop/';
            } else {
                form.submit();
            }
            
        });
        butClearSearchResult.addEventListener('click', (e) => {
            e.preventDefault();
            clearCloseSearchResult();
        });

        function sendRequest(valQuery, container) {
            const data = new FormData();
            data.append('action', 'header_search');
            data.append('nonce', app.nonce);
            data.append('search', valQuery);
            
            fetch(app.ajax, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                return  response.json();
            })
            .then(data => {
   
                if (data.results) {
                    container.querySelector('.results-search-container').innerHTML = data.results;
                    buttonViewAllresults.classList.remove('no-results');
                    // if(data.count == 1) {

                    //     container.querySelector('#results-cont-span').innerHTML = new Intl.NumberFormat().format(data.count) + ' result';
                    // } else {
                    //     container.querySelector('#results-cont-span').innerHTML = new Intl.NumberFormat().format(data.count)  + ' results';
                    // }
                
                } else {

                    container.querySelector('.results-search-container').innerHTML = '<div class="loading-search-result">No products found.</div>';
                    buttonViewAllresults.classList.add('no-results');
                    // containerResult.querySelector('#results-cont-span').innerText = '';
                }
            })
            .catch(error => {
                console.error('Error getting data:', error);
            });

        }
        function clearCloseSearchResult() {
            containerResult.classList.remove('show');
            // containerResult.querySelector('#results-cont-span').innerText = '';
            containerResult.querySelector('.results-search-container').innerHTML = '<div class="loading-search-result">Loading...</div>';
            butClearSearchResult.classList.remove('show-but');
            inputSearch.value = '';
        }
        window.addEventListener('keyup', (event) => {
            if(event.key == 'Esq' && containerResult.classList.contains('show')) {
                clearCloseSearchResult();
            }
            
        });
        window.addEventListener('click', (event) => {
            if(!event.target.closest('.form-search-wrapper')) {
                clearCloseSearchResult();
            }
        });
    }
    searchHeaderForm();

    //close faster than default time notifciation Yith Wishlist
    function universalWishlistDisplayControl() {
        setTimeout(() => {
            const notifWrapper = document.getElementById('yith-wcwl-popup-message');
            if(notifWrapper) {
            
                const observerOptions = {
                    attributes: true,
                    attributeFilter: ['style'],
                    // childList: true,
                    // subtree: true,
                    // characterData: true
                    // characterDataOldValue: true
                };
                const observerCallback = function (mutationsList, observer) {

                    setTimeout(() => {
                        notifWrapper.style.display = 'none';
                    },1500);
                          
                };
        
                const observer = new MutationObserver(observerCallback);
                observer.observe(notifWrapper, observerOptions);
            }
        }, 2000);
    }
    
    universalWishlistDisplayControl();

    function universalWooNotificationControl() {
        function observeElem(notify, additionalSelector = null) {
            if(notify !== null) {
                const observerOptions = {
                    // attributes: true,
                    // attributeFilter: ['style'],
                    childList: true,
                    subtree: true,
                    characterDataOldValue: true,
                    addedNodes: true,
                    removedNodes: true,
                    target: 'div.woocommerce-message',

                };
                const observerCallback = function (mutationsList, observer) {
               
                    setTimeout(() => {
                       
                        if(additionalSelector !== null) {
                            const mesRemove = document.querySelector(additionalSelector);
                            if(mesRemove !== null) {
                                mesRemove.remove();
                            }
                            
                          
                        } else if(notifWrapper !== null){
                            notifWrapper.innerHTML = '';
                        }
                        
                    },3000);
                };
                const observer = new MutationObserver(observerCallback);
                observer.observe(notify, observerOptions);
            }
           
            }
            
            const notifWrapper = document.querySelector('.woocommerce-notices-wrapper');
            if(notifWrapper !== null) {
                observeElem(notifWrapper);
                
            }

            const notifWooMessage = document.querySelector( '#yith-wcwl-form')
            if(notifWooMessage !== null) {
            
                observeElem(notifWooMessage, '.woocommerce-message');
            }
        
    }

    universalWooNotificationControl();

    $('body').on('removed_from_wishlist', function( el, row ) {
        universalWooNotificationControl();
    } );
    
    $('body').on('added_to_cart', function( el, row ) {
        
        if($('body').hasClass('woocommerce-wishlist')) {
           
            setTimeout(() => {
                $('.wishlist-out-of-stock').each(function(index, elem) {
                    $(elem).closest('tr').find('button[name="add-to-cart"]').attr('disabled', 'true');
                });
            }, 300);
           
        }
    } );

    function universalWooNotifyAfterLoad() {
        const notifWrapper = document.querySelector('.woocommerce-notices-wrapper');
        function clearMessage(notify) {
            // console.log(notify);
            if(notify  !== null) {
            
                let childElements = notify.querySelectorAll('*');
                if(childElements.length > 0) {
                    setTimeout(() => {
                        notify.innerHTML = '';
                    },3000);
                }
              
               
            }
            
        }
        if(notifWrapper) {
            clearMessage(notifWrapper);
        }
        if(document.body.classList.contains('woocommerce-wishlist')) {
  
            const notifWrapperMes = document.querySelector('.woocommerce-message');
       
            clearMessage(notifWrapperMes);
        }
        
    }
    universalWooNotifyAfterLoad();

    document.querySelector('.body-blur').addEventListener('click', ()=>{
        document.dispatchEvent(
            new CustomEvent("bodyBlurClick", {bubbles: true}),
        );
    });
    function subscriptionForm() {
         // Contact form Subscription
        document.addEventListener( 'wpcf7submit', function( event ) {
            let inpElem = document.querySelector('.sb__form .input-element');
            let notify = document.querySelector('.sb__form .wpcf7-response-output');
                
                
            setTimeout(() => {
                
                if(event.detail.status == 'mail_sent') {
                    inpElem.classList.remove('filled', 'error');
                    document.getElementById('thank-you-subscribe-form').classList.add('show');
                    notify.innerHTML= '';
                    
                } else {
                    event.target.classList.remove('init');
                    event.target.classList.add('invalid');
                    inpElem.classList.add('error');
                }
            },350);

            setTimeout(() => {
                
                if(event.detail.status !== 'mail_sent') {
                    inpElem.classList.add('error');
                    event.target.classList.remove('invalid');
                    event.target.classList.add('init');
                    notify.innerHTML= '';
                
                } 
                
            },3000);
            // setTimeout(() => {
            //     let notify = document.querySelector('.sb__form .wpcf7-response-output');
                
            //     notify.innerHTML= '';
                
            // },3350);
            
          
            
        }, false );
        const ufwsloaderSvgAnim =  `<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none">
                                        <circle cx="60" cy="60" r="60" fill="white"/>
                                        <circle cx="60" cy="60" r="56.7568" fill="white" stroke="black" stroke-width="6.48649"/>
                                        <g >
                                            <circle class="ufws-loader-circle" stroke="#c5a477" cx="60" cy="60" r="50" stroke-dasharray="320" stroke-width="9" fill="none"/>
                                            <animate attributeName="stroke-dashoffset" stroke-dasharray="320" stroke-dashoffset="320" values="320;0;-320"  dur="6s" begin="0.1s;6s" calcMode="linear" ></animate>
                                        </g>
                                        
                                        <path d="M60.2038 25.9459L41.8572 29.1892L39.8188 29.5946L39.411 31.2162C37.3725 36.8919 35.7418 42.1621 34.111 47.8378C32.4802 53.9189 31.257 59.5946 30.8493 66.0811C30.4416 73.7838 33.2956 79.4594 38.188 84.3243C43.0804 88.7838 50.419 92.027 59.3884 94.054H59.7961H60.6115C61.4269 93.6486 62.65 93.6486 63.4654 93.2432L74.8811 89.1892C77.735 87.5676 79.7735 85.9459 81.812 84.3243L81.812 84.3243C86.7044 79.4594 89.5583 73.3784 89.1506 66.0811C88.7429 59.5946 87.5198 53.5135 85.889 47.8378C84.2582 42.1621 82.6274 36.4865 80.5889 31.2162L80.1812 29.5946C73.6579 28.3784 66.7271 27.1621 60.2038 25.9459Z" fill="black"/>
                                        <path d="M45.067 33.6898L61.0153 30.8108L74.9612 33.6898L74.9618 33.6917C76.5973 38.6264 78.2328 43.5611 79.4595 48.4959C80.6863 53.8425 83.5135 60.8108 83.5135 65.9365C83.5135 71.2831 81.5182 75.7579 77.8378 79.4594C73.7485 83.161 68.376 85.5111 60.6063 87.5675C52.8366 85.9224 47.1117 83.0435 43.0224 79.3419C39.342 76.0517 37.2973 71.5276 37.2973 65.7697C38.1152 59.6004 38.9331 53.8425 40.5688 48.4959C41.7956 43.5606 43.4312 38.6253 45.0669 33.69L45.067 33.6898Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M81.1374 54.6827C81.1518 54.7252 81.1662 54.768 81.1807 54.8109C82.1991 57.8265 83.5135 61.7184 83.5135 66.4865C83.5135 71.7943 81.5175 76.089 77.8378 79.7636C73.7493 83.4382 68.2701 85.8879 60.5019 87.9293C52.7337 86.2962 47.0098 83.4382 42.9213 79.7636C39.2417 76.4973 36.4865 72.1622 37.1973 66.2902C37.4444 64.4398 37.6915 62.6267 37.9611 60.8509C41.5365 63.5197 52.357 70.6248 57.5676 63.2432C65.4224 52.1156 76.9763 53.6703 81.1374 54.6827Z" fill="#CF5B49"/>
                                        <path d="M60 92.4324V120" stroke="black" stroke-width="6.48649"/>
                                    </svg>`;
        
        let spinner =  document.querySelector('.wpcf7-spinner');
        if(spinner !== null) {
            document.querySelector('.wpcf7-spinner').insertAdjacentHTML('afterbegin', ufwsloaderSvgAnim);
        }
        let subscrInp = document.getElementById('subscribe-email-input');
        if(subscrInp !== null) {
            subscrInp.addEventListener('focus', function(){
                document.querySelector('.sb__form .input-element').classList.remove('error');
            });   
        }
                                 
    
    }
   
    subscriptionForm();


});

/* fix loop product content height when hover */
function productContentMinHeight() {
    let lists = document.querySelectorAll('.universal-products');
    if(lists) {
        for(let i=0; i<lists.length; i++) {
            let elements = lists[i].querySelectorAll('.product');
            if(elements) {
                for(let j=0; j<elements.length; j++)
                    elements[j].style.setProperty('--product-min-height', elements[j].clientHeight+'px');
            }
        }
    }
}
function setVhVariableMobile() {
    if(document.documentElement.clientWidth <= 1200) {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
}
function commentFormVarification() {
    if(document.body.classList.contains('single-product')) {
        wc_single_product_params.review_rating_required = 'no';
        let butSubmit = document.querySelector('#commentform');
       
        butSubmit.querySelector('input[type=submit]').addEventListener('click',(e) => {

            if(document.querySelector('#rating').value) {

                let form = document.querySelector('#commentform');
                submitFormUfws(form);

            } else {
                let notify = document.getElementById('rate-error-copied');
                notify.classList.add('show');

                setTimeout(() => {
                    notify.classList.remove('show');
                },3000);
            }
        })
    }
}
function submitFormUfws(form) {
    const submitFormFunction = Object.getPrototypeOf(form).submit;
    submitFormFunction.call(form);
}



const checkQuantityInBag = (buttonAdd) => {

    if( document.body.classList.contains('woocommerce-checkout') ) {
        return false;
    }

    let inpQty = '';
    if(buttonAdd.closest('form.cart')) {
        
        inpQty = buttonAdd.closest('form.cart').querySelector('input.qty');
    
    } else {
        inpQty = buttonAdd.closest('.cart-item').querySelector('input.qty');
    }
     
    const maxInStock = inpQty.getAttribute('max');
    const prodId = inpQty.getAttribute('product-id');
    const valueAdd = inpQty.value;
    const countInCart = document.querySelector('.mini-cart__content').querySelector('input[product-id="' + prodId + '"]'); 

    if(countInCart !== null) {
        if((parseInt(valueAdd) + parseInt(countInCart.value)) > parseInt(maxInStock)) {
            console.log('max');
            showQuantityErrorMessage(maxInStock, countInCart.value);
           return false;
        }

       
    }
    
    return true;

}
const showQuantityErrorMessage = (maxInStock, qtyInCart) => {
    const notifWrapper = document.querySelector('.woocommerce-notices-wrapper');
            let mesAddSingleProduct = `<div class="woocommerce-message" role="alert">
                                            <div>
                                                <a href="/cart/" class="button wc-forward">View cart</a> 
                                                You cannot add that amount to the cart — we have ${maxInStock} in stock and you already have ${qtyInCart} in your cart.
                                            </div>	
                                        </div>`;
                         
            if(notifWrapper !== null) {
            
                notifWrapper.insertAdjacentHTML('afterBegin', mesAddSingleProduct);
            
            } else {
                document.body.insertAdjacentHTML('afterbegin','<div class="woocommerce-notices-wrapper">'+ mesAddSingleProduct +'</div>');
                setTimeout(() => {
                    document.querySelector('div.woocommerce-notices-wrapper').remove();
                }, 3000);
            }

}

document.addEventListener("DOMContentLoaded", function () {
    //productContentMinHeight();
    setVhVariableMobile();
    commentFormVarification();
});
window.addEventListener('resize', (e) => {
    //productContentMinHeight();

    dropdowSingleProductResize();
    showSeoTextResize();
    setVhVariableMobile();

});
window.addEventListener('resize', debounce(() => {
    //productContentMinHeight();
    // dropdowSingleProductResize();
    // showSeoTextResize();
    

}, 250));

