const App = (() => {
  let notes = [];
  let title = "";
  let text = "";
  let id = "";

  const $placeholder = document.querySelector("#placeholder");
  const $form = document.querySelector("#form");
  const $notes = document.querySelector("#notes");
  const $noteTitle = document.querySelector("#note-title");
  const $noteText = document.querySelector("#note-text");
  const $formButtons = document.querySelector("#form-buttons");
  const $formCloseButton = document.querySelector("#form-close-button");
  const $modal = document.querySelector(".modal");
  const $modalTitle = document.querySelector(".modal-title");
  const $modalText = document.querySelector(".modal-text");
  const $modalCloseButton = document.querySelector(".modal-close-button");
  const $colorTooltip = document.querySelector("#color-tooltip");

  const addEventListeners = () => {
    document.body.addEventListener("click", handleBodyClick);
    document.body.addEventListener("mouseover", openTooltip);
    document.body.addEventListener("mouseout", closeTooltip);

    $colorTooltip.addEventListener("click", handleColorTooltipClick);

    $form.addEventListener("submit", handleFormSubmit);
    $formCloseButton.addEventListener("click", closeForm);
    $modalCloseButton.addEventListener("click", closeModal);
  };
  const handleFormSubmit = (event) => {
    event.preventDefault();
    const title = $noteTitle.value;
    const text = $noteText.value;
    const hasNote = title || text;
    if (hasNote) {
      addNote();
    }
  };
  const handleBodyClick = (event) => {
    handleFormClick(event);
    selectNote(event);
    openModal(event);
    deleteNote(event);
  };

  const handleFormClick = (event) => {
    const isFormClicked = $form.contains(event.target);

    const hasNote = $noteTitle.value || $noteText.value;

    if (isFormClicked) {
      openForm();
    } else if (hasNote) {
      addNote();
    } else {
      closeForm();
    }
  };

  const openForm = () => {
    $form.classList.add("form-open");
    $noteTitle.style.display = "block";
    $formButtons.style.display = "block";
  };

  const closeForm = () => {
    $form.classList.remove("form-open");
    $noteTitle.style.display = "none";
    $formButtons.style.display = "none";
    $noteTitle.value = "";
    $noteText.value = "";
  };

  const openModal = (event) => {
    if (event.target.matches(".toolbar-delete")) return;

    if (event.target.closest(".note")) {
      $modal.classList.toggle("open-modal");
      $modalTitle.value = title;
      $modalText.value = text;
    }
  };

  const closeModal = () => {
    editNote();
    $modal.classList.toggle("open-modal");
  };

  const openTooltip = (event) => {
    if (!event.target.matches(".toolbar-color") && !event.target.closest(".color-palette")) {
      return;
    }
    id = event.target.dataset.id;
    const $colorButton = event.target;
    const buttonCoords = $colorButton.getBoundingClientRect();
    const horizontal = buttonCoords.left + window.scrollX + 20;
    const vertical = buttonCoords.bottom + window.scrollY - 20;
    $colorTooltip.style.left = `${horizontal}px`;
    $colorTooltip.style.top = `${vertical}px`;
    $colorTooltip.style.display = "flex";
  };

  // Function to close tooltip
  const closeTooltip = (event) => {
    if (!event.target.matches(".toolbar-color") && !event.target.closest("#color-tooltip")) {
      $colorTooltip.style.display = "none";
    }
  };


  const addNote = () => {
    const title = $noteTitle.value;
    const text = $noteText.value;
    const hasNote = title || text;
    if (hasNote) {
      fetch("php/add_note.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ title, text }),
      })
        .then((response) => response.json())
        .then((data) => {
          notes.push(data);
          render();
          closeForm();
        })
        .catch((error) => console.error("Error adding note:", error));
    }
  };

  const editNote = () => {
    const title = $modalTitle.value;
    const text = $modalText.value;
    fetch("php/edit_note.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id, title, text }),
    })
      .then(() => {
        notes = notes.map((note) =>
          note.id === Number(id) ? { ...note, title, text } : note
        );
        render();
      })
      .catch((error) => console.error("Error editing note:", error));
  };

  const handleColorTooltipClick = (event) => {
    const color = event.target.dataset.color;
    if (color) {
      editNoteColor(color);
    }
  };

  const editNoteColor = (color) => {
    fetch("php/edit_note_color.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id, color }),
    })
      .then(() => {
        notes = notes.map((note) =>
          note.id === Number(id) ? { ...note, color } : note
        );
        render();
      })
      .catch((error) => console.error("Error editing note color:", error));
  };

  const selectNote = (event) => {
    const $selectedNote = event.target.closest(".note");
    if (!$selectedNote) return;
    const [$noteTitle, $noteText] = $selectedNote.children;
    title = $noteTitle.innerText;
    text = $noteText.innerText;
    id = $selectedNote.dataset.id;
  };

  const deleteNote = (event) => {
    event.stopPropagation();
    if (!event.target.matches(".toolbar-delete")) return;
    const id = event.target.dataset.id;
    fetch("php/delete_note.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id }),
    })
      .then(() => {
        notes = notes.filter((note) => note.id !== Number(id));
        render();
      })
      .catch((error) => console.error("Error deleting note:", error));
  };

  const render = () => {
    fetchNotes();
  };

  const fetchNotes = () => {
    fetch("php/fetch_note.php")
      .then((response) => response.json())
      .then((data) => {
        notes = data;
        displayNotes();
      })
      .catch((error) => console.error("Error fetching notes:", error));
  };

  const displayNotes = () => {
    const hasNotes = notes.length > 0;
    $placeholder.style.display = hasNotes ? "none" : "flex";

    $notes.innerHTML = notes
      .map(
        (note) => `
          <div style="background: ${note.color};" class="note" data-id="${note.id}">
              <div class="${note.title && "note-title"}">${note.title}</div>
              <div class="note-text">${note.text}</div>
              <div class="toolbar-container">
                  <div class="toolbar">
                      <img class="toolbar-color" data-id="${note.id}" src="svg/palette.svg">
                      <img data-id="${note.id}" class="toolbar-delete" src="svg/delete.svg">
                  </div>
              </div>
          </div>
        `
      )
      .join("");
  };

  return {
    init: () => {
      render();
      addEventListeners();
    },
  };
})();

App.init();
