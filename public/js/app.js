function debounce(func, wait) {
    let timeout;
    return function(...args) {
      const context = this;
      if (timeout) clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
   }

function addEventListeners() {

    let search = document.querySelector('#searchBar');
    let searchButton = document.querySelector('#searchButton');
    if(searchButton)
      searchButton.addEventListener('click', async function (event) {
      event.preventDefault();
      const auctions = await fetchAuctions(search.value);
      const page = document.querySelector('.auctions-list');
      page.innerHTML = '';
      console.log(Array.isArray(auctions));
      auctions.forEach((auction) => {
        const newAuction = insertAuction(auction);
        page.append(newAuction);
      });
      }
      );

    if (search) {
        const debouncedFunction = debounce(async function (event) {
        event.preventDefault();
        const auctions = await fetchAuctions(search.value);
        const page = document.querySelector('.auctions-list');
        page.innerHTML = '';
        console.log(Array.isArray(auctions));
        auctions.forEach((auction) => {
        const newAuction = insertAuction(auction);
        page.append(newAuction);
        });
    }, 300);

    search.addEventListener('keyup', debouncedFunction);
    }

}

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send(encodeForAjax(data));
}


async function fetchAuctions(text) {
  const url = '/api/search?' + encodeForAjax({
    text: text
  });

  const response = await fetch(url);
  return await response.json();
}


function insertAuction(auction) {
  let newAuction = document.createElement('div');
  newAuction.classList.add("auction-card");
  newAuction.innerHTML = `
    <a href="{{route('auctions', ['id' => ${auction.id}])}}"
        <article>
            <div class="image-container">
                <img src="${ auction.image }" alt="AuctionImage">
            </div>
            <div class="info-container">
                <h3>${ auction.name }</h3>
                <p>Auctioneer: <a href="{route('user', ['id' => ${auction.owner_id}])}}"> ${auction.owner.name}</a></p>
                <div class="image-container">
                    <img src= " ${auction.owner.img }" alt="UserImage" width="100" height="100" style="border-radius: 50%;" >
                </div>
                <p>${ auction.description }</p>

            </div>
        </article>
    </a>
`;

  return newAuction;

}



addEventListeners();


document.addEventListener('DOMContentLoaded', function () {
    var footerWrapper = document.getElementById('footer-wrapper');

    function showFooter() {
        var windowHeight = window.innerHeight;
        var bodyHeight = document.body.offsetHeight;
        var scrollPosition = window.scrollY || window.pageYOffset || document.body.scrollTop + (document.documentElement && document.documentElement.scrollTop || 0);

        if (windowHeight + scrollPosition >= bodyHeight) {
            footerWrapper.style.display = 'block';
        } else {
            footerWrapper.style.display = 'none';
        }
    }

    showFooter(); // Initial check

    window.addEventListener('scroll', showFooter);
});




