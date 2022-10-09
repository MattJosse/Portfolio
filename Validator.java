import java.util.TreeSet;

public class Validator {
	TreeSet<Integer> startpoints, endpoints;
	int N;

	Validator(int N) {
		startpoints = new TreeSet<Integer>();
		endpoints = new TreeSet<Integer>();
		this.N = N;
	}

	void alloc(int addr, int size) {
		startpoints.add(addr);
		endpoints.add(addr + size);
	}

	void free(int addr, int size) {
		startpoints.remove(addr);
		endpoints.remove(addr + size);
	}

	boolean isfree(int addr, int size) {
		if (endpoints == null) return true;
		int déb;
		if (startpoints.floor(addr+size-1)==null) return true;
		else {déb = startpoints.floor(addr+size-1);}
		
		if (déb>=addr) return false;
		return (endpoints.floor(addr)!=null && endpoints.floor(addr)>déb);
	}
}
