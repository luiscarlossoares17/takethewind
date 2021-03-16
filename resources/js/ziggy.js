const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"users.index":{"uri":"users","methods":["GET","HEAD"]},"users.create":{"uri":"users\/create","methods":["GET","HEAD"]},"users.store":{"uri":"users","methods":["POST"]},"users.show":{"uri":"users\/{user}","methods":["GET","HEAD"]},"users.edit":{"uri":"users\/{user}\/edit","methods":["GET","HEAD"]},"users.update":{"uri":"users\/{user}","methods":["PUT","PATCH"]},"users.destroy":{"uri":"users\/{user}","methods":["DELETE"]},"teams.index":{"uri":"teams","methods":["GET","HEAD"]},"teams.create":{"uri":"teams\/create","methods":["GET","HEAD"]},"teams.store":{"uri":"teams","methods":["POST"]},"teams.show":{"uri":"teams\/{team}","methods":["GET","HEAD"]},"teams.edit":{"uri":"teams\/{team}\/edit","methods":["GET","HEAD"]},"teams.update":{"uri":"teams\/{team}","methods":["PUT","PATCH"]},"teams.destroy":{"uri":"teams\/{team}","methods":["DELETE"]},"manager":{"uri":"manager","methods":["GET","HEAD"]},"get_user_teams":{"uri":"userteams\/data","methods":["POST"]},"get_users":{"uri":"users\/data","methods":["POST"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"]},"password.email":{"uri":"password\/email","methods":["POST"]},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"password\/reset","methods":["POST"]},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    for (let name in window.Ziggy.routes) {
        Ziggy.routes[name] = window.Ziggy.routes[name];
    }
}

export { Ziggy };
