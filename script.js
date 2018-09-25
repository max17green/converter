Vue.component('section-component', {
	props: ['text','active','number','count'],
	data() {
		return {
			flag: false,
		}
	},
	methods: {
		changeColor() {
			this.$emit('change-color',this.number);
			
		},

	},
	template: 
	`<div class="section" @click="changeColor" :class="{'section-click': active}">
		<img src="img/section.png"/>
		<div class="text">{{ text }} ({{ count }})</div>
	</div>`
});

Vue.component('message-component', {
	props: ["message"],
	template:
	`<div class="message">
		<div class="info">
			<div class="first">
				<img class="img" src="img/number1.png">
				<div>Q{{message.count}}</div>
			</div>
			<div class="second"> {{message.hours}}h </div>
		</div>
		<div class="message__box">
			<div class="message__box-text">{{ message.txt }}</div>
			<div class="time">Guest, <span>{{message.time}}</span></div>
		</div>

	</div>`
});

let v = new Vue({
	el: ".elem",
	data: {
		sections: [],
		texts: [],
		visibleDialog: false,
		inp: '',
		prevClick: 0,
		messages: [],
		inp2: '',
		count_messages: null,
		count_list: [], //количество сообщений в каждом списке
		
	},
	mounted() {
		this.texts = JSON.parse(localStorage.getItem("list")) || [];
		for(i=0;i<this.texts.length;i++) {
			if (i==0) {
				this.sections.push({
					txt: this.texts[i],
					isActive: true,
					count: localStorage.getItem("count"+String(i)) || 0
				});
			} else {
				this.sections.push({
					txt: this.texts[i],
					isActive: false,
					count: localStorage.getItem("count"+String(i)) || 0
				});
			}
		}
		this.messages = JSON.parse(localStorage.getItem("messages"+String(this.prevClick))) || [];
		this.count_messages	= JSON.parse(localStorage.getItem("count")) || 0;
		secLength = this.sections.length;
	},
	computed: {
		secLength() {
			if (this.sections.length>0) {
				return true
			} else {
				return false
			}
		}
	},
	methods: {
		visibleWindow() {
			this.visibleDialog = !this.visibleDialog;
		},
		addSection() {
			if (this.sections.length==0) {
				this.sections.push({
					txt: this.inp,
					isActive: true,
					count: 0
				});
			} else {
				this.sections.push({
					txt: this.inp,
					isActive: false,
					count: 0
				});
			}
			
			for(i=0;i<this.sections.length;i++) {
				this.texts[i] = this.sections[i].txt;
			}
			
			serialObj = JSON.stringify(this.texts);
			localStorage.setItem("list", serialObj);

			this.visibleDialog = !this.visibleDialog;
			this.inp = '';
			secLength = this.sections.length;
		},
		change(id) {
			this.sections[id].isActive = !this.sections[id].isActive;
			this.sections[this.prevClick].isActive = !this.sections[this.prevClick].isActive;
			this.prevClick = id;
			this.messages = [];
			//Здесь вывод сообщений
			this.messages = JSON.parse(localStorage.getItem("messages"+String(id))) || [];
			for (i=0;i<this.sections.length;i++) {
				this.count_list[i] = localStorage.getItem('count'+String(i));
			}
			
			//alert(id);
		},
		FixedDigits(number, digits, radix) {
			left = "";
			right = number.toString(radix);
			for (i=right.length; i<digits; i++) left += "0";
			return left + right;
		},
		createMes() {
			if (this.inp2 != '') {
				now = new Date();
				time = now.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
				hours = now.getHours();
				this.messages.push({
					txt: this.inp2,
					time: time,
					hours: hours,
					count: this.FixedDigits(this.count_messages+1,4)
				});
				this.inp2 = '';
				//Сохраняем сообщения
				serialObj = JSON.stringify(this.messages);
				localStorage.setItem("messages"+String(this.prevClick), serialObj);
				//Сохраняем количество всех сообщений
				this.count_messages = this.count_messages+1;
				localStorage.setItem("count", this.count_messages);
				//Сохраняем количество для этого списка
				this.sections[this.prevClick].count = this.sections[this.prevClick].count + 1;
				localStorage.setItem("count"+String(this.prevClick), this.sections[this.prevClick].count);
			}
		}
	}
});
