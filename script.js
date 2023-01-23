

document.getElementById('playQuiz').addEventListener('click',
async function() {

    let node = document.getElementById('studySetMain')
    node.style.display = "none";
      
    let node2 = document.getElementById('stopButton')
    node2.style.display = "block";
    

    let node3 = document.getElementById('QuizContain')
    node3.style.display = "block";
      
    this.style.display = "none";

}
)


document.getElementById('stopButton').addEventListener('click',
async function() {

    let node = document.getElementById('studySetMain')
    node.style.display = "block";
    
    let node2 = document.getElementById('playQuiz')
    node2.style.display = "block";
    
    let node3 = document.getElementById('QuizContain')
    node3.style.display = "none";
      
    this.style.display = "none";

}
)


/*************QUIZ SETUP ********/

// ***********REFERENCE***************
// used guidance for the interaction of this game from the following tutorial:
// https://www.youtube.com/watch?v=riDzcEQbX6k&ab_channel=WebDevSimplified

const startQuiz = document.getElementById('StartB2')
const nextQuestion = document.getElementById('nextQButton')
const questionGroup = document.getElementById('question-container')
const questionNode = document.getElementById('question')
const answerButtons = document.getElementById('answer-buttons')
var finalQuizQuestions; 
var currentQuestion;

startQuiz.addEventListener('click', async function() {
  startQuiz.classList.add('hide')
  currentQuestion = 0
  finalQuizQuestions = questions.sort(() => Math.random() - .5)
  questionGroup.classList.remove('hide')
  getNextQuestion()
}
)

nextQuestion.addEventListener('click', () => {
  currentQuestion++
  getNextQuestion()
})

function getNextQuestion() {
  resetState()
  showQuestion(finalQuizQuestions[currentQuestion])
}

function showQuestion(question) {
  questionNode.innerText = question.question
  question.answer.forEach(answer => {
    const button = document.createElement('button')
    button.innerText = answer.text
    button.classList.add('btn')
    if (answer.correct) {
      button.dataset.correct = answer.correct
    }
    button.addEventListener('click', selectAnswer)
    answerButtons.appendChild(button)
  })
}

function resetState() {
  clearStatusClass(document.body)
  nextQuestion.classList.add('hide')
   answerButtons.innerText ="";
}

function selectAnswer(event) {
  const selectedButton = event.target
  const correct = selectedButton.dataset.correct
  setStatusClass(document.body, correct)
  Array.from(answerButtons.children).forEach(button => {
    setStatusClass(button, button.dataset.correct)
  })
  if (finalQuizQuestions.length > currentQuestion + 1) {
    nextQuestion.classList.remove('hide')
  } else {
    startQuiz.innerText = 'Restart'
    startQuiz.classList.remove('hide') //could have seperate button here for clarity
  }
}

function setStatusClass(element, correct) {
  clearStatusClass(element)
  if (correct) {
    element.classList.add('correct')
  } else {
    element.classList.add('wrong')
  }
}

function clearStatusClass(element) {
  element.classList.remove('correct')
  element.classList.remove('wrong')
}


/*******setup questions for quiz *****/

// ***********REFERENCE***************
// used the following site for guidance on setting up AJAX CODE:
// https://www.youtube.com/watch?v=crtwSmleWMA&ab_channel=AdnanAfzal

var questions;

var ajax = new XMLHttpRequest();
var method = "GET";
var url = "getData.php";
var async = true;

ajax.open(method, url, async);
ajax.send();

ajax.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       var data = JSON.parse(this.responseText);
       questions = JSON.parse(JSON.stringify(data));
      //  console.log(data);

        for (var i = 0; i< data.length; i++) {
            const answers = [];
            const numssofar = [];
            answers.push({text:data[i].answer, correct: true });
            if (data.length <= 2) {
                while (answers.length <1) {
                    let x = Math.floor((Math.random() * data.length-1) + 0);
                    if (x!= i && !numssofar.includes(x)) {
                        try {
                            answers.push({text:data[x].answer, correct:false});
                            numssofar.push(x);
                        } catch (error) {  
                        }
                        
                    }
                }

            } else if (data.length <=4) {
                while (answers.length <2) {
                    let x = Math.floor((Math.random() * data.length-1) + 0);
                    if (x!= i && !numssofar.includes(x)) {
                        try {
                            answers.push({text:data[x].answer, correct:false});
                            numssofar.push(x);
                        } catch (error) {  
                        }
                        
                    }
                }
            } else {
            while (answers.length <4) {
                let x = Math.floor((Math.random() * data.length-1) + 0);
                if (x!= i && !numssofar.includes(x)) {
                    try {
                        answers.push({text:data[x].answer, correct:false});
                        numssofar.push(x);
                    } catch (error) { 
                    }
                    
                }
            }
        }
        answers.sort(() => Math.random() - .5)
        questions[i].answer = answers;
        
        }
        // console.log(questions);

    }
}

