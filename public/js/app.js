let page = 1;
const perPage = 9;
let loading = false;


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


    searchButton.addEventListener('click',handleSearchEvent);

    search.addEventListener('keyup', debounce(handleSearchEvent, 300));

    window.addEventListener('scroll', debounce(checkScroll, 200));

    window.addEventListener('scroll', showFooter);

}

async function handleSearchEvent(event) {
    let search = document.querySelector('#searchBar');
    event.preventDefault();
    const auctions = await fetchAuctions(search.value);
    const page = document.querySelector('.auctions-list');
    page.innerHTML = '';
    console.log(Array.isArray(auctions));
    auctions.data.forEach((auction) => {
      const newAuction = insertAuction(auction);
      page.append(newAuction);
    });
}


async function fetchAuctions(text, page) {
    const url = `/api/search?page=${page}&text=${text}`;
    const response = await fetch(url);
    return await response.json();
}


function insertAuction(auction) {
  let newAuction = document.createElement('div');
  newAuction.classList.add("auction-card");
  newAuction.innerHTML = `
    <a href="auctions/${auction.id}"
        <article>
            <div class="image-container">
                <img src="${ auction.image }" alt="AuctionImage">
            </div>
            <div class="info-container">
                <h3>${ auction.name }</h3>
                <p>Auctioneer: <a href="users/${auction.owner_id}"> ${auction.owner.name}</a></p>
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

function appendAuctions(auctions) {
    const pageElement = document.querySelector('.auctions-list');
    auctions.data.forEach((auction) => {
      const newAuction = insertAuction(auction);
      pageElement.append(newAuction);
    });
}


function checkScroll() {
if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200 && !loading) {
    loading = true;
    page++;
    fetchAuctions(document.querySelector('#searchBar').value, page).then((auctions) => {
    appendAuctions(auctions);
    loading = false;
    });
}
}
function handleRating(button) {
    button.disabled = true;
    document.getElementById('rating-button').style.display = 'none';
}

function showFooter() {
    var footerWrapper = document.getElementById('footer-wrapper');
    var windowHeight = window.innerHeight;
    var bodyHeight = document.body.offsetHeight;
    var scrollPosition = window.scrollY || window.pageYOffset || document.body.scrollTop + (document.documentElement && document.documentElement.scrollTop || 0);

    if (windowHeight + scrollPosition >= bodyHeight) {
        footerWrapper.style.display = 'block';
    } else {
        footerWrapper.style.display = 'none';
    }
}



addEventListeners();


document.addEventListener('DOMContentLoaded', function () {
    addEventListeners();
    showFooter();
});
