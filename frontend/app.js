const GET_ALL_ZADATCI = "http://localhost/todoapp/api/get_all_zadatak.php";

const zadatci = fetch(GET_ALL_ZADATCI);

const dohvatiSveZadatke = async () => {
  const response = await fetch(GET_ALL_ZADATCI);
  const zadatci = await response.json();
  //console.log(zadatci);

  if (response.ok) {
    const table = document.getElementById("redTablice");
    table.innerHTML = "";
    zadatci.response.forEach((zadatak) => {
      //ćelija 1
      const tr = document.createElement("tr");
      tr.dataset.id = zadatak.id;
      // ćelija 2
      const tdNaziv = document.createElement("td");
      tdNaziv.textContent = zadatak.naziv_zadatka;
      //ćelija 3
      const tdVrijeme = document.createElement("td");
      tdVrijeme.textContent = zadatak.vrijeme;
      // ćelija 4
      const tdStatus = document.createElement("td");
      tdStatus.textContent = zadatak.zadatak_zavrsen == 1 ? "DA" : "NE";

      const tdAkcije = document.createElement("td");

      const deleteBtn = document.createElement("button");
      deleteBtn.textContent = "obriši";
      deleteBtn.classList.add("delete-btn");
      deleteBtn.addEventListener("click", () => {
        delete_zadatak(zadatak.id); //get one korisnik; ili iz liste dohvatit id pa ga uklonit
      });
      const updateBtn = document.createElement("button");
      updateBtn.textContent =
        zadatak.zadatak_zavrsen == 1 ? "PONIŠTI" : "ZAVRŠI";
      const statusClass =
        zadatak.zadatak_zavrsen == 1 ? "status-complete" : "status-pending";
      updateBtn.classList.add("update-btn", statusClass);
      updateBtn.addEventListener("click", () => {
        update_zadatak(zadatak.id, zadatak.zadatak_zavrsen);
      });

      tr.appendChild(tdNaziv);
      tr.appendChild(tdVrijeme);
      tr.appendChild(tdStatus);
      tr.appendChild(tdAkcije);
      tdAkcije.appendChild(deleteBtn);
      tdAkcije.appendChild(updateBtn);
      table.appendChild(tr);
    });
  }
};

dohvatiSveZadatke();

const POST_METODA = "http://localhost/todoapp/api/add_zadatak.php";
const dodajZadatak = async () => {
  const noviZadatak = document.getElementById("unesiZadatak");
  const naziv_zadatka = noviZadatak.value.trim();
  const statusZadatka = document.getElementById("statusZadatka");
  const status_zadatka = statusZadatka.value.trim();
  const bodyZaSlanje = {
    naziv_zadatka: naziv_zadatka,
    zadatak_zavrsen: status_zadatka,
  };
  const response = await fetch(POST_METODA, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(bodyZaSlanje),
  });

  if (response.ok) {
    console.log(response);
    const message = await response.json();
    noviZadatak.value = "";
    //console.log(message.message);
    dohvatiSveZadatke();
  }
};
dodajZadatak();

const DELETE_ZADATAK = "http://localhost/todoapp/api/delete_zadatak.php";
const delete_zadatak = async (zadatakId) => {
  const bodyZaBrisanje = { id: zadatakId };
  const response = await fetch(DELETE_ZADATAK, {
    method: "DELETE",
    body: JSON.stringify(bodyZaBrisanje),
  });
  if (response.ok) {
    console.log(response);
    const message = await response.json();
    console.log(message.message);
    dohvatiSveZadatke();
  }
};

const UPDATE_ZADATAK = "http://localhost/todoapp/api/update_zadatak.php";

const update_zadatak = async (zadatakId, trenutniStatus) => {
  const noviStatus = trenutniStatus == 1 ? 0 : 1;

  const bodyZaUpdate = {
    id: zadatakId,
    zadatak_zavrsen: noviStatus,
  };

  const response = await fetch(UPDATE_ZADATAK, {
    method: "PUT",
    body: JSON.stringify(bodyZaUpdate),
  });
  if (response.ok) {
    console.log(response);
    const message = await response.json();
    console.log(message.message);
    dohvatiSveZadatke();
  }
};
