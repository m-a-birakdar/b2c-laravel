<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Drag & Drop Sortable List</title>

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #b5aaf5;
        }
        .container {
            font-family: "Poppins", sans-serif;
            background-color: #ffffff;
            padding: 3em 2em;
            width: 90%;
            max-width: 37em;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 0.8em;
        }
        #list {
            position: relative;
            padding-inline-start: 0;
            list-style-type: none;
        }
        .list-item {
            padding: 0.8em 0;
            border-radius: 0.2em;
            margin: 1em auto;
            border: 1px solid #000000;
            text-align: center;
        }
        .list-item:hover {
            cursor: move;
            background-color: #d1c9ff;
            border-color: #8673f2;
            color: #8673f2;
        }
    </style>
</head>
<body>
<div class="container">
   <form action="/drag" method="post">
       @csrf
       <ul id="list"></ul>
       <button type="submit">Save</button>
   </form>
</div>
<!-- Script -->
<script type="text/javascript">
    let currentElement = "";
    let list = document.getElementById("list");
    let initialX = 0,
        initialY = 0;

    const isTouchDevice = () => {
        try {
            //We try to create TouchEvent (it would fail for desktops and throw error)
            document.createEvent("TouchEvent");
            return true;
        } catch (e) {
            return false;
        }
    };

    //Create List Items
    const creator = (count) => {
        for (let i = 1; i <= count; i++) {
            list.innerHTML += `<li class="list-item" data-value ="${i}">Item-${i} <input type="hidden" name="test[]" value="Item-${i}" ></li>`;
        }
    };

    //Returns element index with given value
    const getPosition = (value) => {
        let elementIndex;
        let listItems = document.querySelectorAll(".list-item");
        listItems.forEach((element, index) => {
            let elementValue = element.getAttribute("data-value");
            if (value == elementValue) {
                elementIndex = index;
            }
        });
        return elementIndex;
    };

    //Drag and drop functions
    function dragStart(e) {
        initialX = isTouchDevice() ? e.touches[0].clientX : e.clientX;
        initialY = isTouchDevice() ? e.touches[0].clientY : e.clientY;
        //Set current Element
        currentElement = e.target;
    }
    function dragOver(e) {
        e.preventDefault();
    }

    const drop = (e) => {
        e.preventDefault();
        let newX = isTouchDevice() ? e.touches[0].clientX : e.clientX;
        let newY = isTouchDevice() ? e.touches[0].clientY : e.clientY;

        //Set targetElement(where we drop the picked element).It is based on mouse position
        let targetElement = document.elementFromPoint(newX, newY);
        let currentValue = currentElement.getAttribute("data-value");
        let targetValue = targetElement.getAttribute("data-value");
        //get index of current and target based on value
        let [currentPosition, targetPosition] = [
            getPosition(currentValue),
            getPosition(targetValue),
        ];
        initialX = newX;
        initialY = newY;

        try {
            //'afterend' inserts the element after the target element and 'beforebegin' inserts before the target element
            if (currentPosition < targetPosition) {
                targetElement.insertAdjacentElement("afterend", currentElement);
            } else {
                targetElement.insertAdjacentElement("beforebegin", currentElement);
            }
        } catch (err) {}
    };

    window.onload = async () => {
        customElement = "";
        list.innerHTML = "";
        //This creates 5 elements
        await creator(150);

        let listItems = document.querySelectorAll(".list-item");
        listItems.forEach((element) => {
            element.draggable = true;
            element.addEventListener("dragstart", dragStart, false);
            element.addEventListener("dragover", dragOver, false);
            element.addEventListener("drop", drop, false);
            element.addEventListener("touchstart", dragStart, false);
            element.addEventListener("touchmove", drop, false);
        });
    };
</script>
</body>
</html>
