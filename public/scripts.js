
// Dark mode toggle
function toggleDarkMode(){document.body.classList.toggle('dark');}

// Render public event list & booking buttons
document.addEventListener('DOMContentLoaded',()=>{
 const list=document.getElementById('eventList');
 if(!list) return;
 const events=JSON.parse(localStorage.getItem('events')||'[]');
 if(events.length===0){list.innerHTML='<p>No events available.</p>';return;}
 events.forEach((ev,i)=>{
   const card=document.createElement('div');
   card.className='event-card fade-in';
   card.innerHTML=`<h3>${ev.title}</h3>
    <p><b>Date:</b> ${ev.date}</p><p><b>Venue:</b> ${ev.venue}</p><p>${ev.description}</p>
    <button class='btn' onclick='bookTicket(${i})'>Book Ticket</button>`;
   list.appendChild(card);
 });
});

// Book ticket by saving lastTicket and redirect
function bookTicket(i){
 const events=JSON.parse(localStorage.getItem('events')||'[]');
 if(events[i]){
   localStorage.setItem('lastTicket',JSON.stringify(events[i]));
   location.href='ticket-confirmation.html';
 }
}
