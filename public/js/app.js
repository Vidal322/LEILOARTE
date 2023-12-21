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

    if (searchButton != null)
        searchButton.addEventListener('click',handleSearchEvent);
    if (search != null)
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
<a href="auctions/${auction.id}">
    <article>
        <div class="image-container">
            <img src="${ auction.image }" alt="AuctionImage">
        </div>
        <div class="info-container">
            <h3>${ auction.name }</h3>
            <a href="users/${auction.owner_id}">
                <div class="user-section">
                    <div class="image-container">
                        <img src="${auction.owner.img }" alt="User Image" width="100"
                            height="100" style="border-radius: 50%;">
                    </div>
                <p>${ auction.description }</p>

                </div>
            </a>
            <h3>Auction Overview</h3>
            <div class="auction-overview">
                <div class="auction-values">
                    <div class="auction-dates">
                        <p>Started: ${auction.start_t.slice(0, -3)}</p>
                        <p>Closing: ${auction.end_t.slice(0, -3)}</p>
                    </div>
                    <div class="auction-prices">
                        <p>Starting Price: ${ auction.starting_price }€</p>
                        <p>Top Bid: ${auction.bids.length > 0 ? auction.bids[auction.bids.length - 1].amount + "€": 'No bids yet'}</p>
                    </div>
                </div>
                <h3> Description </h3>
                <p>${ auction.description }</p>
            </div>

                ${auction.active
                    ? `<div class="status-bubble active">
                        <p>Active</p>
                    </div>`
                    : `<div class="status-bubble closed">
                        <p>Closed</p>
                    </div>`}
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


const pusher = new Pusher(pusherAppKey,{
    cluster: pusherCluster,
    encrypted: true
});


const channel = pusher.subscribe('lbaw23113');

channel.bind('followed-auction-canceled-notification', function(event) {
    const message = event.message;
    const auctionId = event.auction_id;
    console.log(event);
    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.innerHTML = `
        <div class="notification-content">
            <span class="notification-title">Auction Canceled</span>
            <p>${message}</p>
        </div>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Remove the notification box after a certain duration
    setTimeout(() => {
        document.body.removeChild(notificationBox);
    }, 10000);

});


channel.bind('followed-auction-ended-notification', function(event) {

    const message = event.message;
    const auctionId = event.auction_id;

    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.innerHTML = `
        <div class="notification-content">
            <span class="notification-title">Auction Ended</span>
            <p>${message}</p>
        </div>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Remove the notification box after a certain duration
    setTimeout(() => {
        document.body.removeChild(notificationBox);
    }, 10000);
});



channel.bind('followed-auction-ending-notification', function(event) {

    const message = event.message;

    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.innerHTML = `
        <div class="notification-content">
            <span class="notification-title">Auction Ending</span>
            <p>${message}</p>
        </div>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Remove the notification box after a certain duration
    setTimeout(() => {
        document.body.removeChild(notificationBox);
    }, 15000);
});

channel.bind('auction-winner-notification', function(event) {

    const message = event.message;

    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.innerHTML = `
        <div class="notification-content">
            <span class="notification-title">Auction Winner!</span>
            <p>${message}</p>
        </div>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Remove the notification box after a certain duration
    setTimeout(() => {
        document.body.removeChild(notificationBox);
    }, 15000);
});


channel.bind('followed-auction-bid-notification', function(event) {


    const message = event.message;

    const notificationBox = document.createElement('div');
    notificationBox.classList.add('notification-box');
    notificationBox.innerHTML = `
        <div class="notification-content">
            <span class="notification-title">New bid</span>
            <p>${message}</p>
        </div>
    `;

    // Append the notification box to the body
    document.body.appendChild(notificationBox);

    // Remove the notification box after a certain duration
    setTimeout(() => {
        document.body.removeChild(notificationBox);
    }, 15000);
});




document.addEventListener('DOMContentLoaded', function () {
    const openFiltersButton = document.getElementById('openFiltersButton');
    const closeFiltersButton = document.getElementById('closeFiltersButton');
    const filtersModal = document.getElementById('filtersModal');
    const overlay = document.getElementById('overlay');
    const body = document.body;
    if (openFiltersButton == null || closeFiltersButton == null || filtersModal == null || overlay == null || body == null)
        return;
    openFiltersButton.addEventListener('click', function (event) {
        event.preventDefault();
        filtersModal.style.display = 'block';
        overlay.style.display='block';
        body.classList.add('modal-open');
    });

    closeFiltersButton.addEventListener('click', function () {
        filtersModal.style.display = 'none';
        body.classList.remove('modal-open');
        overlay.style.display = 'none';
    });

    const applyFiltersButton = document.getElementById('applyFilters');
    applyFiltersButton.addEventListener('click', function () {
        filtersModal.style.display = 'none';
        body.classList.remove('modal-open');
        overlay.style.display = 'none';
        // You can add additional logic here to handle the selected filters
    });
});
