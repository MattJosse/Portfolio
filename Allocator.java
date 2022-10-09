import java.util.HashSet;
import java.util.Vector;

public class Allocator {

	Vector<HashSet<Integer>> freeblocks = new Vector<HashSet<Integer>>();
	int maxk;

	Allocator(int size) {
		
		int k=0;
		while(size>1<<k) k++;
		
		this.maxk=k;
		for(int i=0;i<maxk+1;i++) {
			this.freeblocks.add(new HashSet<Integer>());
		}
		this.freeblocks.get(k).add(0);
		
	}

	static int buddy(int addr, int k) {
		int reste = (addr)%(1<<k+1);
		if (reste==0) return (addr+(1<<k));
		return (addr-(1<<k));
	}
	


	int reserve(int k) {
		//1
		if(k>maxk) throw new RuntimeException();
		
	
		
		int result;
		
		if(!freeblocks.get(k).isEmpty()) {
			result = freeblocks.get(k).iterator().next();
			freeblocks.get(k).remove(result);
			
			return result;
		}
		else {
			result = reserve(k+1);
			freeblocks.get(k).add(buddy(result,k));
			return result;

			
		}

	}

	public int alloc(int size) {
		
		//calcul de k a la main
		int k=0;
		while(size>1<<k) k++;
		
		return this.reserve(k);
	}

	public void free(int addr, int size) {
		
		int k=0;
		while(size>1<<k) k++;
		rec_free(addr,k);
		
		}
		
	
	public void rec_free(int addr, int k) {
		if(k>maxk) return;
		if(freeblocks.get(k).contains(buddy(addr, k))) {
		
			freeblocks.get(k).remove(buddy(addr, k));
			rec_free(addr,k+1);
			return;
		}
		
		
		freeblocks.get(k).add((1<<(k))*((addr)/(1<<(k))));
		
	}
}
