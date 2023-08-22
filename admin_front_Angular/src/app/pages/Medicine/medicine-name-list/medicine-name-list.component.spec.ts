import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MedicineNameListComponent } from './medicine-name-list.component';

describe('MedicineNameListComponent', () => {
  let component: MedicineNameListComponent;
  let fixture: ComponentFixture<MedicineNameListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [MedicineNameListComponent]
    });
    fixture = TestBed.createComponent(MedicineNameListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
