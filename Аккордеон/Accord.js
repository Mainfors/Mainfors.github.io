let parent = document.querySelector('#parent');
		let links  = parent.querySelectorAll('.tab .link a');
		
		for (let link of links) {
			link.addEventListener('click', function(event) {
				let activeTab = parent.querySelector('.tab.active');
				
				if (activeTab) {
					activeTab.classList.remove('active');
				}
				
				let newTab = link.closest('.tab');
				if (newTab !== activeTab) {
					newTab.classList.add('active');
				}
				
				event.preventDefault();
			});
		}